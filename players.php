<?php
include 'navbar.php';
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    .container {
        margin-top: 50px;
    }

    .player-list-box {
        background-color: burlywood;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        
        max-width: 800px;
        margin-bottom: 80px;
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
    </style>
</head>

<body>
    <div class="container">
        
        <div class="player-list-box">
            <h2>Registered Players</h2>
            <table>
                <thead>
                    <tr>
                        <th>FIDE ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Club</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            
                            $selectQuery = "SELECT fide_id, first_name, last_name, club FROM players";
                            $result = mysqli_query($conn, $selectQuery);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($player = mysqli_fetch_assoc($result)) {
                                    ?>
                    <tr>
                        <td><?php echo $player['fide_id']; ?></td>
                        <td><?php echo $player['first_name']; ?></td>
                        <td><?php echo $player['last_name']; ?></td>
                        <td><?php echo $player['club']; ?></td>
                        <td>
                            <a href="edit-player.php?id=<?php echo $player['fide_id']; ?>"
                                class="btn btn-primary">Edit</a>
                            <a href="delete-player.php?id=<?php echo $player['fide_id']; ?>"
                                class="btn btn-danger">Delete</a>
                            <a href="approve-player.php?id=<?php echo $player['fide_id']; ?>"
                                class="btn btn-success">Approve</a>
                        </td>
                    </tr>
                    <?php
                                }
                            } else {
                                ?>
                    <tr>
                        <td colspan="5">No registered players found.</td>
                    </tr>
                    <?php
                            }
                            ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <div>
    <a href="registered_players_report.xlsx" class = "btn btn-success btn-sm" >Registered players report</a>
    </div>
    <?php 
include 'approved_players_report.php';
?>
<div class="text-end">
<?php
$downloadLink = 'approved_players_report.xlsx';
echo "<a href='$downloadLink' download class= 'btn btn-success'>Generate approved players</a>";
?> 
<br>
</body>
<br>
<?php
include 'footer.php';
?>

</html>