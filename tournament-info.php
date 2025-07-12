<?php include 'navbar.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <title>Create Tournament</title>
    <style>
    .form-box {
        background-color: burlywood;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-box label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .form-box input[type="text"],
    .form-box input[type="date"],
    .form-box input[type="number"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .form-box button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-lg-6">
                <div class="form-box">
                    <form action="process-tournament.php" method="post">
                        <div class="mb-3">
                            <label for="tournament_name" class="form-label">
                                <i class="bi bi-card-text"></i> Tournament Name:
                            </label>
                            <input type="text" id="tournament_name" name="tournament_name" required maxlength="30" />
                        </div>

                        <div class="mb-3">
                            <label for="tournament_venue" class="form-label">
                                <i class="bi bi-geo-alt-fill"></i> Tournament Venue:
                            </label>
                            <input type="text" id="tournament_venue" name="tournament_venue" required maxlength="50" />
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">
                                <i class="bi bi-calendar3"></i> Start Date:
                            </label>
                            <input type="date" id="start_date" name="start_date" required />
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">
                                <i class="bi bi-calendar-x-fill"></i> End Date:
                            </label>
                            <input type="date" id="end_date" name="end_date" required />
                        </div>

                        <div class="mb-3">
                            <label for="max_round" class="form-label">
                                <i class="bi bi-list-ol"></i> Number of Rounds:
                            </label>
                            <input type="number" placeholder="minimum rounds=1" id="max_round" name="max_round" required
                                min="1" />
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i> Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add your JavaScript code or additional HTML content here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
<script>
// Get the start date input element
var startDateInput = document.getElementById('start_date');

// Get the current date
var currentDate = new Date();

// Set the minimum date allowed (current date)
var minDate = currentDate.toISOString().split('T')[0];

// Set the min attribute of the start date input element
startDateInput.min = minDate;
</script>




<script>
// Get the start date input element
var startDateInput = document.getElementById('start_date');

// Get the end date input element
var endDateInput = document.getElementById('end_date');

// Set the minimum date allowed (current date)
var minDate = new Date().toISOString().split('T')[0];

// Set the min attribute of the start date input element
startDateInput.min = minDate;

// Add an event listener to the start date input
startDateInput.addEventListener('change', function() {
    // Set the minimum end date based on the selected start date
    endDateInput.min = startDateInput.value;
});
</script>
<?php
include 'footer.php';
?>





</html>