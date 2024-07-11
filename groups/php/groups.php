<?php

include_once '../../common/php/models/Group.php';
include "../../common/php/res.php";
include "../../common/php/authentication.php";

$user = isAuthenticated();
if (!($user instanceof User)) {
  return res(401, ["error" => $user["error"]]);
}

// avoid 200 code for unexpected errors
http_response_code(500);

function sayNotFound($groupID)
{
  //! respond with not found for security (don't tell if it exists or not)
  res(404, ["error" => "Group not found: id=$groupID"]);
}
function getGroupID($db, $fromObject)
{
  $groupID = isset($fromObject["groupID"]) ? $fromObject["groupID"] : null;
  return is_numeric($groupID) && $groupID >= 1
    ? $groupID : null;
}
function getAction($db, $fromObject)
{
  return isset($fromObject["action"]) ? $db->real_escape_string(trim(urldecode($fromObject["action"]))) : null;
}

function getIsGroupAdmin($db, $userID, $groupID)
{
  $stmt = $db->prepare("SELECT isGroupAdmin FROM users_groups WHERE user_id = ? AND group_id = ?");
  $stmt->bind_param("ii", $userID, $groupID);
  $res = $stmt->execute();
  if (!$res)
    return false;
  $res = $stmt->get_result();
  if (!$res->num_rows)
    return false;
  $row = $res->fetch_assoc();
  $stmt->close();
  return !!$row["isGroupAdmin"];
}

function groupsGET($db, $user)
{
  static $ALLOWED_ACTIONS = ["getUsers", "getMembers", "getGroups", "getGroupInfo"];

  switch (getAction($db, $_GET)) {
    //? Get all users (to be added to the group)
    case "getUsers":
      $groupID = getGroupID($db, $_GET);
      if ($groupID === null)
        return sayNotFound($groupID);

      //? get all users that can be added to the group:
      $stmt = $db->prepare(
        "SELECT u.id, u.name, u.email, u.imageURL
         FROM users u
          WHERE u.type = 0 -- normal users only, not admins
          AND NOT EXISTS ( -- where users have NO entries in the subquery
            SELECT 1 FROM users_groups ug -- select without data (1)
              WHERE ug.user_id = u.id -- if user is in any group
              AND ug.group_id = ? -- and user is in this group
          )"
      );

      $stmt->bind_param("i", $groupID);
      $res = $stmt->execute();
      if (!$res) {
        res(500, ["error" => "Internal server error: $db->error"]);
        $stmt->close();
        return;
      }
      $res = $stmt->get_result();
      $values = [];
      while ($row = $res->fetch_assoc()) {
        // quick patch for image URLs
        $exists = isset($row["imageURL"]);
        if ($exists) {
          $row["imageURL"] = (Group::checkImageURL($row["imageURL"]) ? $row["imageURL"] : ('../../users/php/images/' . $row["imageURL"]));
        }
        $values[] = $row;
      }
      $stmt->close();
      return res(200, $values);

    //? Get the row of a group (by id)
    case "getGroupInfo":
      $groupID = getGroupID($db, $_GET);
      if ($groupID === null)
        break;

      // check if im in the group
      $stmt = $db->prepare("SELECT 1 FROM users_groups WHERE user_id = ? AND group_id = ?");
      $stmt->bind_param("ii", $user->id, $groupID);
      $res = $stmt->execute();
      if (!$res)
        return sayNotFound($groupID);
      $res = $stmt->get_result();
      if (!$res->num_rows)
        return sayNotFound($groupID);


      // >> get group info
      $stmt = $db->prepare("SELECT * FROM groups WHERE id = ?");
      $stmt->bind_param("i", $groupID);
      $res = $stmt->execute();
      if (!$res)
        return sayNotFound($groupID);
      $res = $stmt->get_result();
      if ($res->num_rows !== 1)
        return sayNotFound($groupID);
      $row = $res->fetch_assoc();
      $stmt->close();

      return res(200, $row);

    //? Get groups linked to a the currently authenticated user
    case "getGroups":
      // >> get all groups of the currently authenticated user
      $stmt = $db->prepare(
        "SELECT g.* FROM groups AS g
        JOIN users_groups AS ug ON ug.group_id = g.id
        JOIN users AS u ON ug.user_id = u.id
        WHERE u.type = 0 and u.id = ?"
      );
      $stmt->bind_param("i", $user->id);
      $res = $stmt->execute();
      if (!$res) {
        res(500, ["error" => "Internal server error: $db->error"]);
        $stmt->close();
        return;
      }
      while ($gRow = $stmt->fetch()) {
        $values[] = $gRow;
      }
      $stmt->close();

      return res(200, $values);

    //
    case "getMembers":
      $groupID = getGroupID($db, $_GET);
      if ($groupID === null)
        return sayNotFound($groupID);

      // get true if exists // 1 is a placeholder to avoid collecting useless data
      // this avoids running the next big query if not exists
      $stmt = $db->prepare("SELECT EXISTS(SELECT 1 FROM groups WHERE id = ?)");
      $stmt->bind_param('s', $groupID);
      $res = $stmt->execute();
      if (!$res) {
        res(500, ["error" => "Internal server error: $db->error"]);
        $stmt->close();
        return;
      }
      $groupExists = null;
      $stmt->bind_result($groupExists);
      $stmt->fetch();
      $stmt->close();
      if (!$groupExists) {
        return sayNotFound($groupID);
      }
      // > no need to check user existence (already done with authentication.php)

      // check if user is in group
      $stmt = $db->prepare(
        "SELECT EXISTS(
          SELECT 0 FROM users_groups 
            WHERE user_id = ? 
            AND group_id = ?
        )"
      );
      $stmt->bind_param("ii", $user->id, $groupID);
      $res = $stmt->execute();
      if (!$res) {
        res(500, ["error" => "Internal server error: $db->error"]);
        $stmt->close();
        return;
      }
      $isInGroup = false;
      $stmt->bind_result($isInGroup);
      $stmt->fetch();
      $stmt->close();
      if (!$isInGroup) {
        return sayNotFound($groupID);
      }

      // >> get all users of a group
      $stmt = $db->prepare(
        "SELECT u.id, u.name, u.email, u.imageURL, ug.isGroupAdmin, u.id = ? AS isMe
          FROM users AS u
          JOIN users_groups AS ug ON ug.user_id = u.id
          JOIN groups AS g ON ug.group_id = g.id
          WHERE g.id = ?"
      );
      $stmt->bind_param("ii", $user->id, $groupID);
      $res = $stmt->execute();
      if (!$res) {
        res(500, ["error" => "Internal server error: $db->error"]);
        $stmt->close();
        return;
      }
      $res = $stmt->get_result();
      $values = [];
      while ($uRow = $res->fetch_assoc()) {
        // quick patch for image URLs
        $exists = isset($uRow["imageURL"]);
        if ($exists) {
          $uRow["imageURL"] = (Group::checkImageURL($uRow["imageURL"]) ? $uRow["imageURL"] : ('../../users/php/images/' . $uRow["imageURL"]));
        }
        $values[] = $uRow;
      }
      $stmt->close();
      return res(200, $values);

    //
    default:
      return res(400, [
        "error" =>
          "Invalid action. Actions allowed: [" . implode(", ", $ALLOWED_ACTIONS) . "]"
      ]);
  }
}

function groupsPOST($db, $user)
{
  static $ALLOWED_ACTIONS = ["updateGroupInfo", "createGroup", "addRemoveMember", "addRemoveGroupAdmin"];
  $input = json_decode(file_get_contents('php://input'), true);

  $action = isset($input["action"]) ? urldecode($input["action"]) : null;

  $name = isset($input["name"]) ? $db->real_escape_string(trim(urldecode($input["name"]))) : null;
  $imageURL = isset($input["imageURL"]) ? $db->real_escape_string(urldecode($input["imageURL"])) : null;

  switch ($action) {
    case "deleteGroup":
      $groupID = getGroupID($db, $input);
      if ($groupID === null)
        return sayNotFound($groupID);
      $isGroupAdmin = getIsGroupAdmin($db, $user->id, $groupID);
      if (!$isGroupAdmin) {
        return res(403, ["error" => "Not authorized to update this group: groupID=$groupID"]);
      }

      $stmt = $db->prepare("DELETE FROM groups WHERE id = ?");
      $stmt->bind_param("i", $groupID);
      $res = $stmt->execute();
      if (!$res) {
        res(500, ["error" => "Internal server error: $db->error"]);
        $stmt->close();
        return;
      }
      $stmt->close();
      return res(200, ["success" => true]);

    //? Update the row of a group (by id)
    case "updateGroupInfo":
      $groupID = getGroupID($db, $input);
      if ($groupID === null)
        return sayNotFound($groupID);
      $isGroupAdmin = getIsGroupAdmin($db, $user->id, $groupID);
      if (!$isGroupAdmin) {
        return res(403, ["error" => "Not authorized to update this group: groupID=$groupID"]);
      }

      require_once '../../common/php/models/Group.php';

      $nameNew = isset($input["name"]) ? $db->real_escape_string(trim(urldecode($input["name"]))) : null;
      if (!Group::checkName($nameNew)) {
        return res(400, [
          'error' => "Invalid group name: $nameNew"
            . "\n Must be between 1 and 64 alphanumeric characters (Also the following characters are allowed: "
            . Group::$NAME_ALLOWED_SPECIAL_CHARS
            . ")."
        ]);
      }
      // check only if provided
      if (isset($imageURL) && !Group::checkImageURL($imageURL)) {
        return res(400, ["error" => "Invalid image URL: $imageURL"]);
      }

      $stmt = $db->prepare(
        "UPDATE groups 
          SET name = ?, imageURL = ?, updatedAt = NOW()
          WHERE id = ?"
      );
      $stmt->bind_param("ssi", $nameNew, $imageURL, $groupID);
      $res = $stmt->execute();
      $stmt->close();
      if (!$res) {
        return res(500, ["error" => "Failed to update the group: $db->error"]);
      }

      return res(200, ["success" => true]);

    case "createGroup":
      $membersRaw = isset($input["members"]) ? @json_decode(stripslashes(urldecode($input["members"])), true) : null;

      if (!is_string($name) || strlen($name) < 1) {
        return res(400, ["error" => "Group must have a name"]);
      } elseif (!is_array($membersRaw) || count($membersRaw) < 1) {
        return res(400, ["error" => "Group must have at least 1 member other than you"]);
      }

      $res = null;
      $isEditing = isset($input["isEditing"]) ? $input["isEditing"] : false;

      if ($isEditing) {
        $groupID = isset($input["groupID"]) ? $input["groupID"] : null;
        if (!$groupID) {
          return res(400, ["error" => "Missing required data: groupID (int)"]);
        }

        $groupNameNew = isset($input["groupNameNew"]) ? $db->real_escape_string(trim(urldecode($input["groupNameNew"]))) : null;
        if (!$groupNameNew) {
          return res(400, ["error" => "Missing required data: groupNameNew (string)"]);
        }

        $stmt = $db->prepare("UPDATE groups SET name = '?' WHERE id = ?;");
        $stmt->bind_param("si", $groupNameNew, $groupID);
        $res = $stmt->execute();
        $stmt->close();

        return res(200, ["success" => true]);
      } else {
        $memberEmails = [];
        foreach ($membersRaw as $member) {
          try {
            // - validate (parse user object) 
            // - get email (to add to group)
            $memberEmails[] = UserSimple::fromObject($member)->email;
          } catch (InvalidArgumentException $e) {
            return res(400, ["error" => "Invalid value: " . $e->getMessage()]);
          }
        }
        $createdAt = date('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO groups (name, createdAt, imageURL) VALUES (?,?,?);");
        $stmt->bind_param("sss", $name, $createdAt, $imageURL);
        $res = $stmt->execute();
        $stmt->close();

        if (!$res) {
          return res(500, ["error" => "Failed to create group: $db->error"]);
        }

        $groupID = $db->insert_id;
        foreach ($memberEmails as $emailRaw) {
          //stop if something exploded
          if (!$res)
            break;

          // get id of user
          $email = $db->real_escape_string($emailRaw);
          $stmt = $db->prepare("SELECT id FROM users WHERE email = ?;");
          $stmt->bind_param("s", $email);
          $res = $stmt->execute();
          if (!$res)
            continue;
          $id = null;
          $stmt->bind_result($id);
          $stmt->fetch();
          $stmt->close();
          if ($id === null)
            return;
          $stmt = $db->prepare("INSERT INTO users_groups (group_id, user_id) VALUES (?, ?);");
          $stmt->bind_param("ii", $groupID, $id); // Assuming both group_id and user_id are integers
          $res = $stmt->execute();
          $stmt->close();
        }
        $stmt = $db->prepare("INSERT INTO users_groups (group_id, user_id, isGroupAdmin) VALUES (?, ?, 1);");
        $stmt->bind_param("is", $groupID, $user->id);
        $res = $stmt->execute();
        if (!$res)
          return res(500, ["error" => "Failed to set group admin: $db->error"]);
        $stmt->close();
        return res(200, ["success" => true, "groupID" => $groupID]);
      }

    case "addRemoveMember":
      $groupID = isset($input["groupID"]) ? $input["groupID"] : null;
      $memberID = isset($input["memberID"]) ? $input["memberID"] : null;
      $isAdd = isset($input["isAdd"]) ? !!$input["isAdd"] : null;
      if ($groupID === null || $memberID === null || $isAdd === null) {
        return res(400, ["error" => "Missing required data: groupID=$groupID, memberID=$memberID"]);
      }

      //? check if already a member in group
      $stmt = $db->prepare("SELECT 1 FROM users_groups WHERE group_id = ? AND user_id = ? LIMIT 1");
      $stmt->bind_param("ii", $groupID, $memberID);
      $res = $stmt->execute();
      $stmt->store_result();

      //? if adding and already in group
      //? or removing and not in group
      if ($stmt->num_rows === $isAdd) {
        $stmt->close();
        return res(400, ["error" => "Member is not in group: groupID=$groupID, memberID=$memberID"]);
      }
      $stmt->close();

      //? add/remove user to group
      $q = $isAdd
        ? "INSERT INTO users_groups (group_id, user_id) VALUES (?, ?);"
        : "DELETE FROM users_groups WHERE group_id = ? AND user_id = ?;";
      $stmt = $db->prepare($q);
      $stmt->bind_param("ii", $groupID, $memberID);
      $res = $stmt->execute();
      $stmt->close();
      if (!$res) {
        return res(500, ["error" => "Failed to update group: $db->error"]);
      }
      return res(200, ["success" => true]);

    case "addRemoveGroupAdmin":
      $groupID = isset($input["groupID"]) ? $input["groupID"] : null;
      $memberID = isset($input["memberID"]) ? (int) $input["memberID"] : null;
      $isGroupAdmin = isset($input["isGroupAdmin"]) ? !!$input["isGroupAdmin"] : null;
      if (!$groupID || !$memberID || $isGroupAdmin === null) {
        return res(400, ["error" => "Missing required data: groupID (int)"]);
      }

      $stmt = $db->prepare("UPDATE users_groups SET isGroupAdmin = ? WHERE group_id = ? AND user_id = ?;");
      $stmt->bind_param("iii", $isGroupAdmin, $groupID, $memberID);
      $res = $stmt->execute();
      $stmt->close();
      if (!$res) {
        return res(500, ["error" => "Failed to update group: $db->error"]);
      }
      return res(200, ["success" => true]);

    default:
      return res(400, [
        "error" => "Action not allowed. Allowed actions: [\"" . implode("\", \"", $ALLOWED_ACTIONS) . "\"]",
        "input" => $input,
      ]);
  }
}


// 

$db = mysqli_connect("localhost", "root", "", "convoconnect", 3306);
if (!$db) {
  return res(500, ["error" => "Connection failed: " . mysqli_connect_error()]);
}

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
  case "GET":
    groupsGET($db, $user);
    break;
  case "POST":
    groupsPOST($db, $user);
    break;
  default:
    res(405, null, "text/plain");
}

$db->close();
