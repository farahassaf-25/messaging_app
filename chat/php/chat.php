<?php

include "../../common/php/res.php";
include "../../common/php/authentication.php";
include_once "./groups/php/groups.php";

$user = isAuthenticated();
if (!($user instanceof User)) {
  return res(401, ["error" => $user["error"]]);
}


function groupExists($db, $groupID)
{
  $stmt = $db->prepare("SELECT * FROM groups WHERE id = ?");
  $stmt->bind_param("i", $groupID); // Assuming $groupID is an integer
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->num_rows > 0;
}
function isMember($db, $memberID, $groupID)
{
  $stmt = $db->prepare("SELECT * FROM users_groups WHERE user_id = ? AND group_id = ?");
  $stmt->bind_param("ii", $memberID, $groupID); // Assuming $memberID and $groupID are integers
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->num_rows > 0;
}
function canUseGroup($db, $memberID, $groupID)
{
  //? will say not found in both cases for security (not telling outsiders if it exists or not)
  return groupExists($db, $groupID) && isMember($db, $memberID, $groupID);
}

//

function chatGET($db, $user)
{
  static $ALLOWED_ACTIONS = ["pollMessages", "getMessage"];

  $groupID = getGroupID($db, $_GET);
  if (!canUseGroup($db, $user->id, $groupID))
    return sayNotFound($groupID);
  $action = getAction($db, $_GET);


  switch ($action) {
    case "pollMessages":
      $afterMS = isset($_GET["afterMS"]) ? $db->real_escape_string($_GET["afterMS"]) : null;
      if (!is_numeric($afterMS) || $afterMS < 0)
        return res(400, ["error" => "Invalid afterMS parameter. Expected a number >=0"]);

      $afterDate = date("Y-m-d H:i:s", $afterMS / 1000);

      //? get last 50 messages
      $stmt = $db->prepare(
        "SELECT * FROM messages 
         WHERE group_id = ? AND createdAt > ? 
         ORDER BY createdAt ASC 
         LIMIT 50"
      );
      $stmt->bind_param("is", $groupID, $afterDate);
      $res = $stmt->execute();
      if (!$res)
        return res(500, ["error" => $stmt->error]);
      $rows = [];
      $res = $stmt->get_result();
      while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
      }
      return res(200, ["success" => true, "messages" => $rows]);


    case "getMessage":

    default:
      return res(400, [
        "error" => "Action not allowed. Allowed actions: [\"" . implode("\", \"", $ALLOWED_ACTIONS) . "\"]",
      ]);
  }

}


function chatPOST($db, $user)
{
  static $ALLOWED_ACTIONS = ["sendMessage", "deleteMessage"];

  $input = json_decode(file_get_contents('php://input'), true);

  $groupID = getGroupID($db, $input);
  if (!canUseGroup($db, $user->id, $groupID))
    return sayNotFound($groupID);

  $action = getAction($db, $input);

  switch ($action) {
    default:
      return res(400, [
        "error" => "Action not allowed. Allowed actions: [\"" . implode("\", \"", $ALLOWED_ACTIONS) . "\"]",
      ]);
  }
}

//

$db = mysqli_connect("localhost", "root", "", "convoconnect", 3306);
if (!$db) {
  return res(500, ["error" => "Connection failed: " . mysqli_connect_error()]);
}


$method = $_SERVER["REQUEST_METHOD"];
$action = getAction($db, $_GET);
switch ($method) {
  case "GET":
    chatGET($db, $user);
    break;
  case "POST":
    chatPOST($db, $user);
    break;
  default:
    res(405, null, "text/plain");
}

$db->close();
