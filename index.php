<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
    
    body {
        margin: 0;
        padding: 0;
        
    }

    .content-container {
        background-image: url("images/chesser.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh; 
        opacity: 1.5;
        text-align: center;
        color:black;
        font-style:normal;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        
    }
    .content-container {
  display: flex;
  flex-direction: column;
  height: 600px; 
}

.content-box {
  display: none;
}

.active {
  display: block;
  animation: rotateContent 20s infinite;
}

@keyframes rotateContent {
  0% {
    opacity: 0;
  }
  20% {
    opacity: 1;
  }
  40% {
    opacity: 0;
  }
  100% {
    opacity: 0;
  }
}

    a {
        text-decoration: none;

    }
    a:hover {
color: yellow;
    }
   
</style>

    <title>ChessFlame</title>
</head>

<body>

    <header>
    
        <nav class="navbar navbar-expand-md navbar-light bg-danger">
            <div class="container-xxl">
                <a href="index.php" class="navbar-brand">
                    <span class="fw-bold text-light" style="font-size:25px">
                        <i class="fas fa-chess-knight"></i>
                        ChessFlame
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav"
                    aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end align-centre" id="main-nav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> LOG IN</a>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php"><i class="bi bi-pen"></i> REGISTER</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Features.php"><i class="bi bi-award-fill"></i> FEATURES</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="view.php"><i class="bi bi-circle-half"></i> MATCHES AND RANKING</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contacts.php"><i class="bi bi-person-lines-fill"></i> CONTACTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php"><i class="fa fa-user fa-2x"></i>  </a>
                        </li>
                    </ul>
                </div>
            </div>
            
        </nav>
    
    </header>
    
    <div class="content-container">
  <div class="content-box">
    <h3>Are you new to chess? Learn and train <a href="https://lichess.org/learn#/" target="_blank"><br>here
    to get ready for the next tournament!</a></h3>
  </div>
  <div class="content-box">
    <h1>ChessFlame is a powerful chess tournament management tool dedicated to serve arbiters and players.</h1>
  </div>
  <div class="content-box">
    <h3>Players can view their pairings and results with just a few clicks</h3>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        // Get all the content boxes
var contentBoxes = document.querySelectorAll('.content-box');
var activeIndex = 0;

function rotateContent() {
  // Removing the "active" class from the current active content box
  contentBoxes[activeIndex].classList.remove('active');

  // Increment the active index
  activeIndex = (activeIndex + 1) % contentBoxes.length;

  // Add the "active" class to the next content box
  contentBoxes[activeIndex].classList.add('active');
}

// Initial rotation
rotateContent();

// Rotate the content every 10 seconds
setInterval(rotateContent, 10000);

    </script>
    
   
    
</body>


</html>
<?php
  include 'footer.php';
  ?> 