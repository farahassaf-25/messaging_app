<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="styles/login_register.css">
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="styles/dark_mode.css">
    <title>ConvoConnect | Change Password</title>
</head>

<body>
    <div class="login-page">
        <div class="box">
            <div class="form">
                <form class="login-form" action="change_password.php" method="POST" id="change-password-form">
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
                    <input type="email" name="email" required placeholder="Enter Your Email" autocomplete="off" />
                    <div class="password-input">
                        <input type="password" name="password" required placeholder="Enter Your Password" id="pass" autocomplete="off" />
                        <i class="fas fa-eye-slash password-toggle-icon"></i>
                    </div>
                    <div class="password-input">
                        <input type="password" name="confirmpass" required placeholder="Confirm Your Password" id="confirmpass" autocomplete="off" />
                        <i class="fas fa-eye-slash password-toggle-icon"></i>
                    </div>
                    <span id="valid-pass" class="valid-pass"></span>
                    <span id="confirm-pass-msg" class="valid-pass"></span>
                    <button type="submit" class="signin">Update Password</button>
                    <p class="signup"><span><a href="login_admin.php">Sign In</a></span></p>
                </form>
            </div>
        </div>
    </div>
    <div id="liveAlertPlaceholder"></div>

    <script src="../../common/scripts/appendAlert.js"></script>
    <?php if (!empty($_SESSION['error_message'])) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof appendAlert === 'function') {
                    appendAlert("<?= $_SESSION['error_message'] ?>", "danger", true, 5000);
                } else {
                    console.error("appendAlert function is not defined.");
                }
            });
        </script>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof appendAlert === 'function') {
                    appendAlert("<?= $_SESSION['success_message'] ?>", "success", true, 5000);
                } else {
                    console.error("appendAlert function is not defined.");
                }
            });
        </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <script src="scripts/login.js"></script>
    <script src="scripts/switch_mode.js"></script>
</body>

</html>