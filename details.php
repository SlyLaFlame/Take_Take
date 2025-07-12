<?php
include 'navbar.php';
include 'connection.php';
include 'select-tournament.php';

//Retrieve the tournament ID from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournament_id'])) {
    $selectedTournamentId = $_POST['tournament_id'];}


// Retrieve the list of tournaments from the database
$tournamentsQuery = "SELECT * FROM tournament_details";
$tournamentsResult = mysqli_query($conn, $tournamentsQuery);

// Check if any tournaments are available
if ($tournamentsResult && mysqli_num_rows($tournamentsResult) > 0) {
    // Check if a tournament is selected
    if (isset($_POST['tournament_id'])) {
        $selectedTournamentId = $_POST['tournament_id'];

        // Retrieve the tournament details using the selected tournament_id
        $tournamentQuery = "SELECT * FROM tournament_details WHERE tournament_id = $selectedTournamentId";
        $tournamentResult = mysqli_query($conn, $tournamentQuery);
        $tournament = mysqli_fetch_assoc($tournamentResult);

        // Check if the tournament exists
        if ($tournament) {
            $tournamentName = $tournament['tournament_name'];
            $tournamentVenue = $tournament['tournament_venue'];
            $startDate = $tournament['start_date'];
            $endDate = $tournament['end_date'];
            $maxRound = $tournament['max_round'];
            ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    .container {
        margin-top: 50px;
    }

    .tournament-details-box {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 50px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .tournament-details-box h2 {
        font-size: 24px;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        margin-bottom: 10px;
    }

    .tournament-details-box p {
        margin-bottom: 5px;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
            'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-style: italic;
    }
    </style>
</head>

<body>
    <div class="details content">
        <div class="container">
            <h1>Tournament Details</h1>

            <div class="tournament-details-box">
                <h2><?php echo $tournament['tournament_name']; ?></h2>
                <p>Venue: <?php echo $tournament['tournament_venue']; ?></p>
                <p>Start Date: <?php echo $tournament['start_date']; ?></p>
                <p>End Date: <?php echo $tournament['end_date']; ?></p>
                <p>Number of Rounds: <?php echo $tournament['max_round']; ?></p>
            </div>

            <h2>Approved Players</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>FIDE ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Club</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch the registered players from the database
                    $playersQuery = "SELECT * FROM players where approved = 1";
                    $playersResult = mysqli_query($conn, $playersQuery);

                    if ($playersResult && mysqli_num_rows($playersResult) > 0) {
                        while ($player = mysqli_fetch_assoc($playersResult)) {
                            
                            ?>
                    <tr>
                        <td><?php echo $player['fide_id']; ?></td>
                        <td><?php echo $player['first_name']; ?></td>
                        <td><?php echo $player['last_name']; ?></td>
                        <td><?php echo $player['club']; ?></td>
                    </tr>
                    <?php
                        }
                    } else {
                        ?>
                    <tr>
                        <td colspan="4">No players found.</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <form method="POST" action="pairing.php">
                <input type="hidden" name="tournament_id" value="<?php echo $selectedTournamentId; ?>">
                <button type="submit" class="btn btn-primary">Launch Pairings</button>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
        } else {
            echo "Selected tournament not found.";
        }
    } else {
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Tournament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    .container {
        margin-top: 50px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Select Tournament</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="tournamentSelect" class="form-label">Choose a Tournament:</label>
                <select class="form-select" name="tournament_id" id="tournamentSelect" required>
                    <option value="" selected disabled>Select a tournament</option>
                    <?php
                        // Display the list of tournaments in the dropdown menu
                        while ($tournament = mysqli_fetch_assoc($tournamentsResult)) {
                            ?>
                    <option value="<?php echo $tournament['tournament_id']; ?>">
                        <?php echo $tournament['tournament_name']; ?>
                    </option>
                    <?php
                        }
                        ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Show Tournament Details</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>


<?php
    }
} else {
    echo "No tournaments found.";
}


