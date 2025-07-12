<?php
include 'navbar-user.php';
require 'configuration.php';

if (isset($_POST['submit'])) {
  // Retrieve form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  $selectquery = "SELECT password FROM signup_players WHERE username = ?";
  
  // Prepare the statement
  $stmt = mysqli_prepare($conn, $selectquery);
  
  // Bind the parameter and set its value
  mysqli_stmt_bind_param($stmt, "s", $username);
  
  // Execute the statement
  mysqli_stmt_execute($stmt);
  
  // Bind the result to a variable
  mysqli_stmt_bind_result($stmt, $hashedPassword);
  
  // Fetch the result
  mysqli_stmt_fetch($stmt);
  
  // Compare the entered password with the stored hashed password
  if (password_verify($password, $hashedPassword)) {
    // Password is correct
    // Proceed with login
    
    $_SESSION['login'] = $username;
    // Player login successful
    header('Location: register.php');
    exit();
  } else {
    // Invalid username or password
    $error = "Invalid username or password.";
    header('Location: login.php?error=' . urlencode($error));
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <title>Login page for chess players</title>
    <style>
    .form-box {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        background-color: burlywood;
        margin: 100px;
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <div class="row justify-content-center my-5">
        <div class="col-lg-6">
            <div class="form-box">
                <form action="" method="post">
                    <legend>Login Queens Gambit</legend>
                    <div class="mb-2 mt-3 text-lg-end">

                        <a href="signup.php" class="btn btn-secondary">
                            Sign up
                        </a>

                    </div>

                    <label for="username" class="form-label">Username:</label>
                    <div class="mb-2 input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="username" required/>
                    </div>
                    
                    <label for="password" class="form-label">Password:</label>
                    <div class="mb-2 input-group">
                        <span class="input-group-text">
                            <i class="bi bi-key-fill"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="password" required />
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
                            Log in
                        </button>
                    </div>
                </form>
                <div class="mt-2 text-center">
                    <p>Don't have an account? <a class="signup link" style=text-decoration:none href="signup.php">Signup
                            here</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
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
<?php
include 'footer.php';
?>
