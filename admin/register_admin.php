<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="styles/login_register.css">
    <link rel="stylesheet" href="styles/dark_mode.css">
    <link rel="stylesheet" href="../common/styles/global.css">
    <title>ConvoConnect | Register Admin</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['error_message'])) {
        echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
        unset($_SESSION['error_message']);
    }
    if (isset($_SESSION['success_message'])) {
        echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
        unset($_SESSION['success_message']);
    }
    ?>
    <div class="login-page">
        <div class="box">
            <div class="form">
                <form class="login-form" action="php/register_admin.php" method="POST">
                    <div class="theme-toggle">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="logo">
                        <svg class="logo-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4800 4800" width="100px" height="100px">
                            <g fill="none" stroke="white" stroke-width="200">
                                <path d="M1350 3937a1693 1693 0 0 0 1050 363c396.3 0 761 -135.6 1050 -363M1900 974.7C1205.1 1188.2 700 1835.1 700 2600c0 192.5 32 377.5 91 550M2900 974.7c694.9 213.5 1200 860.4 1200 1625.3 0 192.5 -32 377.5 -91 550" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4300 3600c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 4300 3600m-2800 0c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 1500 3600m1400 -2700c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 2900 900" />
                            </g>
                        </svg>
                        <h2>ConvoConnect</h2>
                    </div>

                    <input type="text" name="name" required placeholder="Enter Your Name" autocomplete="off" />
                    <input type="email" name="email" required placeholder="Enter Your Email" autocomplete="off" />
                    <div class="password-input">
                        <input type="password" name="password" required placeholder="Enter Your Password" id="pass" autocomplete="off" />
                        <i class="fas fa-eye-slash password-toggle-icon"></i>
                    </div>
                    <div class="password-input">
                        <input type="password" name="confirmpass" required placeholder="Confirm Your Password" id="confirmpass" autocomplete="off" />
                        <i class="fas fa-eye-slash password-toggle-icon"></i>
                    </div>
                    <button type="submit" class="signin">SIGN UP</button>
                    <p class="signup">Already Have An Account? <span><a href="login_admin.php">Sign In</a></span></p>
                </form>
            </div>
        </div>
    </div>

    <script src="scripts/login.js"></script>
    <script src="scripts/switch_mode.js"></script>
</body>

</html>