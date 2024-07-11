<?php
session_start();
include_once "../common/php/authentication.php";

// Redirect to login page if user is not authenticated
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit; // Ensure no further code execution after redirection
}

// Fetch current user's details
$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
} else {
    header("location: users.php"); // Redirect if current user not found (this should ideally not happen)
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="styles/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <link rel="stylesheet" href="../common/styles/global.css" />
    <link rel="stylesheet" href="../common/styles/sidebar.css" />
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
</head>

<body>

    <div class="container">
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
      
        <!-- Users Section -->
         
        <div class="users-wrapper">
            <section class="users"> 
                <header>
                    <div class="content">
                        <img src="php/images/<?php echo $row['imageURL']; ?>" alt="">
                        <div class="details">
                            <span><?php echo $row['name']," ", $row['lname']; ?></span>
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

        <!-- Chat Section -->
        <div class="chat-wrapper">
            <section class="chat-area">
                <header>
                    <?php 
                        $id = mysqli_real_escape_string($conn, $_GET['id']);
                        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$id}");
                        if(mysqli_num_rows($sql) > 0){
                            $row = mysqli_fetch_assoc($sql);
                            ?>
                            <a href="home.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                            <img src="php/images/<?php echo $row['imageURL']; ?>" alt="">
                            <div class="details">
                                <span><?php echo $row['name']," ",$row['lname']; ?></span>
                                <p><?php echo $row['status']; ?></p>
                            </div>
                            <?php
                        } else {
                            header("location: users.php"); // Redirect if user not found
                            exit;
                        }
                    
                    ?>
                </header>
                <div class="chat-box">
                    <!-- Placeholder for chat messages -->
                </div>
                <form action="#" class="typing-area">
                    <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $id; ?>" hidden>
                    <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                    <button><i class="fab fa-telegram-plane"></i></button>
                </form>
            </section>
        </div>
          
    </div>

    <!-- JavaScript Files -->
    <script src="scripts/users.js"></script>
    <script src="scripts/chat.js"></script>

    <!-- Responsive JavaScript for toggling -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const usersWrapper = document.querySelector('.users-wrapper');
        const chatWrapper = document.querySelector('.chat-wrapper');
        const backIcon = document.querySelector('.back-icon');

        // Initially show the users list
        usersWrapper.classList.add('active');

        // Show chat and hide users list when a user is clicked
        document.querySelectorAll('.users-list a').forEach(function(userLink) {
            userLink.addEventListener('click', function(event) {
                event.preventDefault();
                usersWrapper.classList.remove('active');
                chatWrapper.classList.add('active');
            });
        });

        // Show users list and hide chat when back icon is clicked
        if (backIcon) {
            backIcon.addEventListener('click', function(event) {
                event.preventDefault();
                chatWrapper.classList.remove('active');
                usersWrapper.classList.add('active');
            });
        }
    });
</script>
</body>

</html>