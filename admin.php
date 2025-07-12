<?php
require 'configuration.php';
include 'connection.php';

$error = "";
if (isset($_POST['submit'])) {
  // Retrieve form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare the SELECT query with placeholders
  $selectquery = "SELECT password FROM admin WHERE username = ?";
  
  // Prepare the statement
  $stmt = mysqli_prepare($conn, $selectquery);
  
  // Bind the parameter and set its value
  mysqli_stmt_bind_param($stmt, "s", $username);
  
  // Execute the statement
  mysqli_stmt_execute($stmt);
  
  // Bind the result to a variable
  mysqli_stmt_bind_result($stmt, $storedPassword);
  
  // Fetch the result
  mysqli_stmt_fetch($stmt);
  
  // Compare the entered password with the stored hashed password
  if (password_verify($password, $storedPassword)) {
    // Password is correct
    // Proceed with authentication
    
    $_SESSION['admin'] = $username;
    // Admin login successful
    header('Location: create-new-tournament.php');
    exit();
  } else {
    // Invalid username or password
    $error = "Invalid username or password.";
    header('Location: admin.php?error=' . urlencode($error));
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
  />
  <style>
    /* Add CSS styles here */
    body {
      background-image: url("images/robotchess.jpeg");
      background-size: cover;
      background-repeat: no-repeat;
      height: 100vh;
    }

    .form-box {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-box legend {
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
    }

    .form-box label {
      font-weight: 500;
      margin-bottom: 5px;
    }

    .form-box input[type="text"],
    .form-box input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      margin-bottom: 10px;
    }

    .form-box button[type="submit"] {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
  <title>Admin Login</title>
</head>

<body>
  <div class="row justify-content-center my-5">
    <div class="col-lg-4">
      <div class="form-box">
        <form action="" method="post">
          <legend>ADMIN LOGIN</legend>
          <label for="username" class="form-label">
            <i class="bi bi-person-fill"></i> Username:
          </label>
          <div class="mb-2 input-group">
            <span class="input-group-text">
              <i class="bi bi-person-fill"></i>
            </span>
            <input
              type="text"
              class="form-control"
              id="username"
              name="username"
              placeholder="Enter your username"required
            />
          </div>

          <label for="password" class="form-label">
            <i class="bi bi-key-fill"></i> Password:
          </label>
          <div class="mb-2 input-group">
            <span class="input-group-text">
              <i class="bi bi-key-fill"></i>
            </span>
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Enter your password" required
            />
            <span class="input-group-text">
                <i class="bi bi-eye" id="togglePassword"></i>
            </span>
          </div>
          <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo urldecode($_GET['error']); ?>
            </div>
          <?php } ?>

          <div class="mb-2 mt-5 text-center">
            <button type="submit" name="submit" class="btn btn-primary">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>
  <script>
    // Get the toggle password button element
    var togglePassword = document.querySelector("#togglePassword");

    // Get the password input element
    var passwordInput = document.querySelector("#password");

    // Toggle the password visibility when the button is clicked
    togglePassword.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePassword.classList.remove("bi-eye");
            togglePassword.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            togglePassword.classList.remove("bi-eye-slash");
            togglePassword.classList.add("bi-eye");
        }
    });
</script>
</body>
</html>
