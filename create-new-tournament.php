
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
    /* Add CSS styles here */
    body {
        margin: 0;
        padding: 0;
    }

    .background-container {
        background-image: url("images/newtournament.jpeg");
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh; /* Adjust the height as needed */
    }
    h4 {
        color: white;
    }
    h1 {
        color: white;
    }
    .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    z-index: 1;
    background-color: yellow;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown:hover .dropdown-content {
    display: block;
    color: blue;
  }
</style>
    <title>Create New Tournament</title>
</head>

<body>

<div class="background-container">
    <header>
        
        <nav class="navbar navbar-expand-md navbar-light bg-danger">
            <div class="container-xxl">
                <a href="index.php" class="navbar-brand">
                    <span class="fw-bold text-light" style="font-size: 25px">
                        <i class="fas fa-chess-pawn"></i>
                        ChessFlame
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav"
                    aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end align-centre" id="main-nav">
                    <ul class="navbar-nav custom-navbar">
                        <li class="nav-item">
                            <a class="nav-link" href="tournament-info.php"><i class="bi bi-pen"></i>Tournament
                                Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="details.php"><i class="bi bi-info-circle"></i> Tournament
                                Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="players.php"><i class="bi bi-people"></i> Players</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pairing.php"><i class="bi bi-journal-text"></i> Pairings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="rank.php"><i class="bi bi-trophy"></i> Rank</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="bi bi-person"></i>Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <?php
session_start(); // Start the session

if (isset($_SESSION['admin'])) {
  $adminUsername = $_SESSION['admin'];
 /*  echo "Welcome, $adminUsername!"; */
 echo "<h4>Welcome arbiter $adminUsername !</h4>";
} else {
  // Admin is not logged in, redirect to the login page
  header('Location: admin-login.php');
  exit();
}
?>

<div class="dropdown">
  <h1>What do you want to do today?</h1>
  <div class="dropdown-content">
    <a href="tournament-info.php">Create New Tournament</a>
    <a href="players.php">Approve players</a>
    <a href="pairing.php">Launch pairings</a>
  </div>
</div>
    </header>
</div>


</body>
<?php
  include 'footer.php';
  ?>

</html>