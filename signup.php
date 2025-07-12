<?php
include 'navbar-user.php';
include 'connection.php';

if (isset($_POST['submit'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    // Check if passwords match
    if ($password === $passwordConfirmation) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert user data into the database
        $sql = "INSERT INTO signup_players (username, email, password, password_confirmation) 
                VALUES ('$username', '$email', '$hashedPassword', '$hashedPassword')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            header('Location: login.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Passwords do not match, display an error message
        echo "Password and password confirmation do not match.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <title>Signup page for chess players</title>
    <style>
    a.login.link:hover {
        text-decoration: underline;
    }

    .form-box {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        background-color: burlywood;
    }
    </style>
</head>

<body>
    <div class="row justify-content-center my-5">
        <div class="col-lg-6">
        <div class="form-box">
    <form action="" method="post">
        <legend>Signup for Queens Gambit</legend>
        <label for="username" class="form-label">Username:</label>
        <div class="mb-2 input-group">
            <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" />
        </div>
        <label for="email" class="form-label">Email:</label>
        <div class="mb-2 input-group">
            <span class="input-group-text">
                <i class="bi bi-envelope-at-fill"></i>
            </span>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" />
        </div>
        <label for="password" class="form-label">Password:</label>
        <div class="mb-2 input-group">
            <span class="input-group-text">
                <i class="bi bi-key-fill"></i>
            </span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
            <span class="input-group-text">
                <i class="bi bi-eye" id="togglePassword"></i>
            </span>
        </div>
        <label for="password_confirmation" class="form-label">Confirm Password:</label>
        <div class="mb-2 input-group">
            <span class="input-group-text">
                <i class="bi bi-key"></i>
            </span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                placeholder="Confirm your password" />
            <span class="input-group-text">
                <i class="bi bi-eye" id="togglePassword"></i>
            </span>
        </div>
        <div class="mb-2 mt-5 text-center">
            <button type="submit" name="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>
                <div class="mt-3 text-center">
                    <p>Already have an account? <a class="login link" style="text-decoration:none"
                            href="login.php">Login
                            here</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Get the toggle password button element
    var togglePassword = document.querySelector("#togglePassword");

    // Get the password input elements
    var passwordInput = document.querySelector("#password");
    var passwordConfirmationInput = document.querySelector("#password_confirmation");

    // Toggle the password visibility when the button is clicked
    togglePassword.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordConfirmationInput.type = "text";
            togglePassword.classList.remove("bi-eye");
            togglePassword.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordConfirmationInput.type = "password";
            togglePassword.classList.remove("bi-eye-slash");
            togglePassword.classList.add("bi-eye");
        }
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
<?php
include 'footer.php';
?>

</html>