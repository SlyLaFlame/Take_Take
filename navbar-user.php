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
    <title>Navbar User</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-danger">
            <div class="container-xxl">
                <a href="index.php" class="navbar-brand">
                    <span class="fw-bold text-light" style="font-size: 25px">
                        <i class="fas fa-chess-rook"></i>
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
                            <a class="nav-link" href="view.php"><i class="bi bi-circle-half"></i> MATCHES AND RANKING</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="features.php"><i class="bi bi-award-fill"></i> FEATURES</a>
                        </li>

                       

                        <li class="nav-item">
                            <a class="nav-link" href="contacts.php"><i class="bi bi-person-lines-fill"></i> CONTACTS</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>

</html>