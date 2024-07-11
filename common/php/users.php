<?php

include_once "authentication.php";
include_once "res.php";

$user = isAuthenticated();
if (!($user instanceof User)) {
  return res(401, ["error" => $user["error"]]);
}

function get($db, $user)
{
  $action = isset($_GET["action"]) ? $_GET["action"] : null;
  switch ($action) {
    case "me":
      return res(200, [
        "success" => true,
        "me" => [ // without password
          "id" => $user->id,
          "name" => $user->name,
          "email" => $user->email,
          "imageURL" => (filter_var($user->imageURL, FILTER_VALIDATE_URL) ? $user->imageURL : ('../../users/php/images/' . $user->imageURL)),
          "type" => $user->type,
          "createdAt" => $user->createdAt,
        ]
      ]);

    default:
      // get all emails and images except mine
      $stmt = $db->prepare("SELECT id, name, email, imageURL FROM users WHERE id != ? and type = 0");
      $stmt->bind_param("i", $user->id);
      $res = $stmt->execute();
      if (!$res)
        return res(500, ["error" => $stmt->error]);
      $res = $stmt->get_result();
      if (!$res->num_rows)
        return res(404, ["error" => "No users found"]);
      $members = [];
      while ($row = $res->fetch_assoc()) {
        // quick patch for image URLs 
        if (isset($row["imageURL"])) {
          $row["imageURL"] = (filter_var($row["imageURL"], FILTER_VALIDATE_URL)
            ? $row["imageURL"]
            : imageToBase64('../../users/php/images/' . $row["imageURL"]));
        }
        $members[] = $row;
      }
      return res(200, $members);
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
    get($db, $user);
    break;
  // case "POST":
  //   post($db, $user);
  //   break;
  default:
    res(405, null, "text/plain");
}

$db->close();
