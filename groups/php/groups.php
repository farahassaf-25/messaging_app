<?php

include "../../common/php/authentication.php";
$user = isAuthenticated();
if (!($user instanceof User)) {
  header("Content-Type: application/json");
  http_response_code($user["code"]);
  echo json_encode(["error" => $user["error"]]);
  return;
}


function get($db, $user)
{
  header('Content-Type: application/json');

  $action = isset($_GET["action"]) ? $_GET["action"] : null;
  $actionsAllowed = ["getGroups", "getUsers"];
  $q = "";
  switch ($action) {
    case "getGroups":

      // >> get all groups of a user
      $q = "FROM groups g SELECT g.*"
        . " JOIN users_groups ug ON g.id = ug.groupID"
        . " JOIN users u ON ug.userEmail = u.email"
        . " WHERE u.email = '$user->email';";
      break;

    case "getUsers":
      $groupID = isset($_GET["groupID"]) ? $_GET["groupID"] : null;
      if (!$groupID) {
        http_response_code(400);
        echo json_encode(["error" => "Missing groupID"]);
        return;
      }
      $groupExists = $db->query("SELECT id FROM groups WHERE id = $groupID")->num_rows > 0;
      if (!$groupExists) {
        http_response_code(404);
        echo json_encode(["error" => "Group does not exist: id=$groupID"]);
        return;
      }
      // > no need to check user existence (already done with authentication.php)

      // >> get all users of a group
      $q = "FROM users u SELECT u.*"
        . " JOIN users_groups ug ON u.id = ug.userEmail"
        . " JOIN groups g ON ug.groupID = g.id"
        . " WHERE g.id = $groupID;";
      break;

    default:
      http_response_code(400);
      echo json_encode(["error" => "Invalid action. Actions allowed: [" . implode(", ", $actionsAllowed) . "]"]);
      return;
  }

  $res = $db->query($q);

  if (!$res) {
    http_response_code(500);
    echo json_encode(["error" => $db->error]);
    return;
  }

  $values = [];
  while ($row = $res->fetch_assoc()) {
    $values[] = $row;
  }

  http_response_code(200);
  echo json_encode($values);
}

function post($db)
{
  $name = isset($_POST["name"]) ? $db->real_escape_string(trim($_POST["name"])) : null;
  $membersRaw = isset($_POST["members"]) ? @json_decode(stripslashes($_POST["members"]), true) : null;

  header('Content-Type: application/json');

  if (!is_string($name) || strlen($name) < 1) {
    http_response_code(400);
    echo json_encode(['error' => 'Group must have a name.']);
    return;
  } elseif (!is_array($membersRaw) || count($membersRaw) < 2) {
    http_response_code(400);
    echo json_encode(['error' => 'Group must have at least 2 members.']);
    return;
  }

  $res = null;
  $groupID = null;
  $isEditing = isset($_POST["isEditing"]) ? $_POST["isEditing"] : false;

  if ($isEditing) {
    if (isset($_POST["groupID"])) {
      $groupID = $db->real_escape_string(trim($_POST["groupID"]));
    } else {
      http_response_code(400);
      echo json_encode(['error' => 'Missing required data: groupID']);
      return;
    }
    $groupNameNew = isset($_POST["groupNameNew"]) ? $db->real_escape_string(trim($_POST["groupNameNew"])) : null;
    if (!$groupNameNew) {
      http_response_code(400);
      echo json_encode(['error' => 'New group name cannot be empty.']);
      return;
    }

    $db->query("UPDATE groups SET name = '$groupNameNew' WHERE id = '$groupID'");

  } else {
    $memberEmails = [];
    foreach ($membersRaw as $member) {
      $error = null;
      try {
        // - validate (parse user object) 
        // - get email (to add to group)
        $memberEmails[] = UserSimple::fromObject($member)->email;
      } catch (InvalidArgumentException $e) {
        $error = $e->getMessage();
      }
      // 'catch' block does not send the response correctly: send from 'foreach' block
      if ($error) {
        http_response_code(500);
        echo json_encode(['error' => "Failed to parse user information: " . $error]);
        return;
      }
    }
    $createdAt = date('Y-m-d H:i:s');

    $res = $db->query("INSERT INTO groups (name, createdAt) VALUES ('$name', '$createdAt');");
    $groupID = $db->insert_id;
    foreach ($memberEmails as $emailRaw) {
      //stop if something exploded
      if (!$res)
        break;

      $email = $db->real_escape_string($emailRaw);
      $res = $res && $db->query("INSERT INTO users_groups (groupID, userEmail) VALUES ('$groupID', '$email');");
    }
  }
  if (!$res) {
    http_response_code(500);
    echo json_encode(["error" => $db->error]);
    return;
  }
  http_response_code(200);
  echo json_encode(['success' => true, 'groupID' => $groupID]);
}

// 

$db = @mysqli_connect("localhost", "root", "", "mysql", 3306)
  or die("Connection failed: " . mysqli_connect_error());

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
  case "GET":
    get($db, $user);
    break;
  case "POST":
    post($db);
    break;
  default:
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed: ($method)"]);
}

$db->close();


