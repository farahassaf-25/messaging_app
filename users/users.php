<?php
session_start();
include_once "../common/php/authentication.php";
if (!isset($_SESSION['unique_id'])) {
  header("location: login.php");
  exit; // Ensure no further code execution after redirection
}
?>

<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <link rel="stylesheet" href="../common/styles/global.css" />
  <link rel="stylesheet" href="../common/styles/sidebar.css" />
  <link rel="stylesheet" href="styles/style.css">
</head>

<body>
  <div class="container-fluid">
    <nav class="sidebar d-flex flex-column justify-content-between">
      <div class="logo text-center py-4">
        <img src="../assets/logo.svg" alt="logo" width="64px" height="64px" class="logo-img">
      </div>
      <ul class="nav flex-column flex-grow-1">
        <li class="nav-item mb-3">
          <a class="nav-link active" href="../users/users.php"><i class="fas fa-home"></i><span class="nav-text">Home</span></a>
        </li>
        <li class="nav-item mb-3">
          <a class="nav-link" href="../user/profile.php"><i class="fas fa-cog"></i><span class="nav-text">Settings</span></a>
        </li>
        <li class="nav-item mb-3">
          <a href="../groups/create.php" class="nav-link"><i class="fas fa-solid fa-comments"></i><span class="nav-text">Create Groups</span></a>
        </li>
      </ul>
      <div class="text-center mb-3">
        <a class="nav-link" href="#">
          <img src="../assets/defaultProfile.webp" class="rounded-circle pfp" width="40" alt="User">
        </a>
        <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i><span class="nav-text">Logout</span></a>
      </div>
    </nav>

    <div class="content-wrapper">
      <section class="users">
        <header>
          <div class="content">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            $row = mysqli_fetch_assoc($sql);
            ?>
            <img src="php/images/<?php echo $row['imageURL']; ?>" alt="">
            <div class="details">
              <span><?php echo $row['name']; ?></span>
              <p><?php echo $row['status']; ?></p>
            </div>
          </div>
          <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
        </header>
        <div class="search">
          <span class="text">Select a user to start chat</span>
          <input type="text" placeholder="Enter name to search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">
          <!-- Placeholder for users list -->
        </div>
      </section>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <script src="scripts/users.js"></script>
</body>

</html>