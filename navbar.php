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
        background-image: url("images/pawnking.jpeg");
        background-size: cover;
        background-repeat: no-repeat;
    }

    .nav-link {
        color: #fff !important;
        font-weight: bold;
    }

    .navbar .navbar-nav .nav-link:hover {
        color: yellow !important;
    }
    </style>

    <title>Create New Tournament</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-danger">
            <div class="container-xxl">
                <a href="create-new-tournament.php" class="navbar-brand">
                    <span class="fw-bold text-white">
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
                            <a class="nav-link" href="tournament-info.php"><i class="bi bi-pen"></i>Tournament
                                Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="details.php"><i class="bi bi-info-circle"></i>
                                Tournament Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="players.php"><i class="bi bi-people"></i> Players</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pairing.php"><i class="bi bi-journal-text"></i>
                                Pairings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="rank.php"><i class="bi bi-trophy"></i> Rank</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>

</html>