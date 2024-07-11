<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <style>
    .container-fluid {
      display: flex;
    }

    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 70px;
      background-color: rgb(101, 16, 147);
      padding-top: 20px;
      text-align: center;
      /* Center items horizontally */
      border-radius: 10px;
      /* Adds border radius */
      margin: 5px;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }

      .main-content {
        flex: 1 0 100%;
      }

      .logo {
        justify-content: flex-start;
      }
    }

    .main-content {
      margin-left: 200px;
      padding: 20px;
      flex-grow: 1;
      align-items: center;
      justify-content: center;
      display: flex;

    }

    .logo-img {
      display: block;
      margin: 0 auto;
    }

    .centered-div {
      width: 300px;
      background-color: rgb(101, 16, 147);
      padding: 20px;
      border-radius: 10px;
      text-align: center;

    }


    .wrapper {
      justify-content: center;
      background-color: rgb(101, 16, 147);

      align-items: center;
    }

    .wrapper header {
      justify-content: center;
      align-items: center;
      display: flex;
      color: white;
    }

    label {
      color: white;
      font-weight: bold;
    }

    .fieldbutton {
      text-align: center;
      margin-top: 20px;
      color: white;
    }

    .fieldbutton input[type="submit"] {
      display: inline-block;
      padding: 10px 20px;
      background-color: rgb(101, 16, 147);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .fieldbutton input[type="submit"]:hover {
      background-color: white;
      color: black;
    }

    .link {
      color: white;
    }

    .logo-img {
      color: white;
    }

    .file-input {
      border: 2px solid #ccc;
      padding: 10px;
      display: inline-block;
      cursor: pointer;
      /* Change cursor to pointer on hover */
    }

    /* Hover effect */
    .file-input:hover {
      background-color: #f0f0f0;
      /* Change background color on hover */
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="main-content">

      <div class="wrapper">
        <div class="logo">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="50%" height="100%">
            <g fill="none" stroke="currentColor" stroke-width="1">
              <path d="M13.5 39.37A16.927 16.927 0 0 0 24 43c3.963 0 7.61-1.356 10.5-3.63M19 9.747C12.051 11.882 7 18.351 7 26c0 1.925.32 3.775.91 5.5M29 9.747C35.949 11.882 41 18.351 41 26c0 1.925-.32 3.775-.91 5.5" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M43 36c0 1.342-.528 2.56-1.388 3.458A5 5 0 1 1 43 36m-28 0c0 1.342-.528 2.56-1.388 3.458A5 5 0 1 1 15 36M29 9c0 1.342-.528 2.56-1.388 3.458A5 5 0 1 1 29 9" />
            </g>
          </svg>
        </div>
        <section class="form signup">
          <header>ConvoConnect</header>
          <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="error-text"></div>
            <div class="field input">
              <label>First Name</label>
              <input type="text" name="name" placeholder="Enter your first name" required>
            </div>
            <div class="field input">
              <label>Last Name</label>
              <input type="text" name="lname" placeholder="Enter your last name" required>
            </div>
            <div class="field input">
              <label>Email Address</label>
              <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="field input">
              <label>Password</label>
              <input type="password" name="password" placeholder="Enter new password" required>
              <i class="fas fa-eye"></i>
            </div>
            <div class="field image">
              <label>Select Image</label>
              <div class="fieldbutton">

                <input type="file" name="imageURL" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
              </div>
            </div>
            <div class="fieldbutton">

              <div class="field button">
                <input type="submit" name="submit" value="Continue to Chat">
              </div>
            </div>
          </form>
          <div class="link">Already signed up? <a href="login.php" style="color: white;">Login now</a></div>
        </section>
      </div>

      <script src="scripts/pass-show-hide.js"></script>
      <script src="scripts/signup.js"></script>

</body>

</html>