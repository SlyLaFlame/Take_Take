<?php
require 'configuration.php';

// Check if player ID is provided
if (isset($_GET['id'])) {
    $playerId = $_GET['id'];

    // Fetch player data from the database
    $query = "SELECT * FROM players WHERE fide_id = $playerId";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $player = mysqli_fetch_assoc($result);

        // Check if the update form is submitted
        if (isset($_POST['submit'])) {
            // Retrieve updated form data
            $newFirstName = $_POST['first_name'];
            $newLastName = $_POST['last_name'];
            $newClubId = $_POST['club'];

            // Retrieve the club name from the clubs table
            $clubQuery = "SELECT club_name FROM clubs WHERE club_id = '$newClubId'";
            $clubResult = mysqli_query($conn, $clubQuery);
            $clubRow = mysqli_fetch_assoc($clubResult);
            $newClub = $clubRow['club_name'];

            // Update the player information in the database
            $updateQuery = "UPDATE players SET first_name = '$newFirstName', last_name = '$newLastName', club = '$newClub', club_id = '$newClubId' WHERE fide_id = $playerId";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Player information updated successfully
                header("Location: players.php");
                exit();
            } else {
                echo "Error updating player information: " . mysqli_error($conn);
            }
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
    <!-- Add your CSS stylesheets here -->
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Edit Player</h1>

        <!-- Edit Player Form -->
        <form action="" method="POST">
            <div class="row justify-content-center my-5">
                <div class="col-lg-6">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name"
                            value="<?php echo $player['first_name']; ?>" required>
                    </div> <br>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $player['last_name']; ?>"
                            required>
                    </div> <br>
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
                        $selected = ($clubId == $player['club_id']) ? 'selected' : '';
                        echo "<option value=\"$clubId\" $selected>$clubName</option>";
                    }
                    ?>
                        </select>
                    </div> <br>
                    <button type="submit" name="submit" class="btn btn-primary">Update Player </button>
        </form>
    </div>

    <!-- Add your JavaScript code here -->
</body>

</html>
<?php
    } else {
        echo "Player not found.";
    }
} else {
    echo "No player ID provided.";
}
?>