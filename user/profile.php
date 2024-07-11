<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About me Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <link rel="stylesheet" href="../common/styles/global.css" />
    <link rel="stylesheet" href="../common/styles/sidebar.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: lightblue;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .button {
            width: 350px;
            height: 50px;
            background-color: #651093;
            color: white;
            border: 2px solid white;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .button:hover {
            background-color: white;
            color: #651093;
        }

        .button1 {
            width: 200px;
            padding: 10px 20px;
            background-color: rgb(217, 212, 212);
            color: rgb(101, 16, 147);
            border: 2px solid white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .button1:hover {
            background-color: white;
            color: rgb(101, 16, 147);
        }

        .container-fluid {
            display: flex;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .link {
            color: white;
        }

        .ss {
            align-items: center;
            justify-content: center;
        }

        .close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .close-icon:hover {
            color: red;
        }
    </style>
</head>

<body>
    <a href="#" class="close-icon"><i class="fas fa-times"></i></a>

    <div class="container-fluid">
        <nav class="col-md-2 sidebar d-flex flex-column justify-content-between">
            <div class="logo text-center py-4">
                <img src="../assets/logo.svg" alt="logo" width="64px" height="64px" class="logo-img" />
            </div>
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item mb-3">
                    <a class="nav-link" href="../users/users.php"><i class="fas fa-home"></i><span class="nav-text">Home</span></a>
                </li>
                <li class="nav-item mb-3">
                    <a class="nav-link active" href="../user/profile.php"><i class="fas fa-cog"></i><span class="nav-text">Settings</span></a>
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

        <div class="container">
            <img src="https://tse2.mm.bing.net/th?id=OIP.VixIl8SYp8qaYA-o_k_IJgHaHa&pid=Api&P=0&h=220" class="rounded-circle" width="100" height="100" alt="Profile Image">
            <br>
            <input type="text" class="textbox" placeholder="Full Name" required style="font-weight: bold;">
            <a href="#" class="edit-icon fas fa-edit"></a>
            <br>
            <br>
            <button class="button"><a href="../groups/create.php">Create A Group</a></button>
            <br>
            <button class="button">Add Feedback</button>
        </div>
    </div>
</body>

</html>