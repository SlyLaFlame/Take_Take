<?php
include 'navbar-user.php';  
include 'connection.php';

session_start(); // Start the session

if (isset($_SESSION['login'])) {
  $username = $_SESSION['login'];
  echo " <h4>Welcome player $username!</h4>";
} else {
  // Player is not logged in, redirect to the login page
  header('Location: login.php');
  exit();
}
// Process player registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fideId = $_POST['fide_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $clubId = $_POST['club'];
  
    // Retrieve the club name from the clubs table based on the club_id
    $clubNameQuery = "SELECT club_name FROM clubs WHERE club_id = '$clubId'";
    $result = mysqli_query($conn, $clubNameQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $clubName = $row['club_name'];

        // Insert the player details into the database
        $insertQuery = "INSERT INTO players (fide_id, first_name, last_name, club_id, club) 
                        VALUES ('$fideId', '$firstName', '$lastName', '$clubId', '$clubName')";

        mysqli_query($conn, $insertQuery);
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

    <style>
    .container {
        margin-top: 10px;
        margin-left: 50px auto;
    }

    .player-form-box {
        background-color: burlywood;
        padding: 20px;
        border-radius: 50px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
      
    }

    .player-form-box h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .player-form-box form div {
        margin-bottom: 10px;
    }

    .player-list-box {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .player-list-box table {
        width: 100%;
    }

    .player-list-box th,
    .player-list-box td {
        padding: 10px;
    }

    .player-list-box th {
        font-weight: 600;
    }

    .player-list-box a {
        margin-right: 10px;
    }
    .quote {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  height: 100%;
  padding-right: 50px;
}

.quote-box {
  background-color:antiquewhite;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  position:absolute;
        top: 140px;
        right: 10px;
}

.quote h1 {
  font-size: 30px;
  text-align: center;
  margin: 0;
}

    </style>
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="player-form-box">
                    
                    <form action="process-players.php" method="POST">
                    
                        <div>
                        <h2>Register for tournament</h2>
                            <label for="fide_id">FIDE ID:</label>
                            <input type="number" id="fide_id" name="fide_id" required />
                        </div>
                        <div>
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required />
                        </div>
                        <div>
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required />
                        </div>
                        <div>
                            <label for="club">Club:</label>
                            <select id="club" name="club" required>
                                <option value="" disabled selected>Select a club</option>
                                <?php
        // Retrieve the list of clubs from the database
        $clubsQuery = "SELECT * FROM clubs";
        $clubsResult = mysqli_query($conn, $clubsQuery);

        // Display the clubs as options in the select dropdown
        while ($row = mysqli_fetch_assoc($clubsResult)) {
            $clubId = $row['club_id'];
            $clubName = $row['club_name'];
            echo "<option value=\"$clubId\">$clubName</option>";
        }
        ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                       
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
    .logout-button {
        position:absolute;
        top: 150px;
        right: 20px;
    }
    
    
</style>

<a href="logout_player.php" class="btn btn-danger logout-button">Log Out</a>
<div class="col-lg-6">
            <div class="quote">
                <div class="quote-box">
                    <h1>"Register now and secure yourself <br> a chance to compete among <br> the best in Kenya!"</h1>
                </div>
            </div>
        </div>

</body>

</html>
<?php
include 'footer.php';
?>