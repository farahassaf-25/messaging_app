<!DOCTYPE html>
<html>

<head>
  <title>Create Group</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <link rel="stylesheet" href="../common/styles/global.css" />
  <link rel="stylesheet" href="../common/styles/sidebar.css" />
  <link rel="stylesheet" href="../common/styles/screen.css" />

  <link rel="stylesheet" href="./styles/usersContainer.css" />
  <link rel="stylesheet" href="./styles/create.css" />
</head>

<body>
  <nav class="col-md-2 sidebar d-flex flex-column justify-content-between">
    <div class="logo text-center py-4">
      <img src="../assets/logo.svg" alt="logo" width="64px" height="64px" class="logo-img" />
    </div>
    <ul class="nav flex-column flex-grow-1">
      <li class="nav-item mb-3">
        <a class="nav-link" href="../users/users.php"><i class="fas fa-home"></i><span class="nav-text">Home</span></a>
      </li>
      <li class="nav-item mb-3">
        <a class="nav-link" href="../user/profile.php"><i class="fas fa-cog"></i><span class="nav-text">Settings</span></a>
      </li>
      <li class="nav-item mb-3">
        <a href="../groups/create.php" class="nav-link active"><i class="fas fa-solid fa-comments"></i><span class="nav-text">Create Groups</span></a>
      </li>
    </ul>
    <div class="text-center mb-3">
      <a class="nav-link" href="#">
        <img src="../assets/defaultProfile.webp" class="rounded-circle pfp" width="40" alt="User">
      </a>
      <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i><span class="nav-text">Logout</span></a>
    </div>
  </nav>

  <div id="createGroupBox" class="screen">
    <div id="groupInfo">
      <div class="groupImage">
        <img src="../assets/defaultGroup.png" class="pfp" id="groupImage" />

        <div class="editContainer">
          <button type="button" id="editGroupButton" data-bs-toggle="modal" data-bs-target="#imageURLModal">
            <i class="fa-regular fa-image"></i>
            Select image
          </button>
        </div>
      </div>

      <div id="groupNameBox">
        <!-- no need for a form, I'm using ajax -->
        <div>
          <input id="groupName" name="groupName" placeholder="Group name" />
          <button id="createButton" type="submit" class="colored">Create</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="imageURLModal" tabindex="-1" aria-labelledby="imageURLModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Select group image</h1>
        </div>
        <div class="modal-body mb-3">
          <img src="../assets/defaultGroup.png" alt="Group image preview" class="pfp" id="imageURLPreview" />
          <input type="text" id="imageURLInput" />
          <br />
          <div class="buttons">
            <button id="imageURLRandomCat">
              <i class="fa-solid fa-cat" id="imageURLRandomCatIcon" style="--fa-animation-duration: 0.75s"></i>
              Random cat
            </button>
            <!-- Avoid popup blocker - using a link -->
            <a href="https://postimages.org" target="_blank">
              <button id="imageURLUpload">
                <i class="fa-solid fa-upload"></i>
                Upload new (Postimage)
              </button>
            </a>
          </div>
          <br />
        </div>
        <div class="modal-footer">
          <button data-bs-dismiss="modal">Cancel</button>
          <button class="colored" id="setGroupImage">Continue</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script src="../common/scripts/appendAlert.js"></script>
  <script src="../common/scripts/getMyInfo.js"></script>

  <script src="./scripts/fetchGroupSafe.js"></script>
  <script src="./scripts/usersContainer.js"></script>
  <script src="./scripts/userCard.js"></script>
  <script src="./scripts/alertAuth.js"></script>
  <script src="./scripts/create.js"></script>
</body>

</html>