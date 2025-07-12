<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-image: url("images/shem.JPG");
        background-color:burlywood;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .container {
        max-width: 600px;
        justify-content: center;
    }

    .splash-spacing {
        margin-bottom: 20px;
    }

    .splash--quote {
        line-height: 1.5;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-row {
        margin-bottom: 10px;
    }

    .form-group label {
        font-weight: bold;
    }

    .contact--send-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .contact--send-button .js-feedback-loading {
        display: none;
        margin-left: 5px;
    }

    .contact--feedback-confirm,
    .contact--feedback-error {
        display: none;
        margin-top: 10px;
        color: green;
    }

    .contact--feedback-error {
        color: red;
    }

    @media (min-width: 768px) {
        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .form-column {
            flex: 1;
            margin-right: 20px;
            margin-left: 100px;
        }

        .image-column {
            flex: 1;

        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-column">
            <div class="splash-spacing">
                <h2>Contact us</h2>
                <p>
                    Have you tried ChessFlame and something is missing? Do you have any idea for improvement? Do you
                    want
                    to ask about something not stated in the FAQ? Do not hesitate and contact us. Your suggestions and
                    opinions really matter to us. Let's make tournament organization better.
                </p>
            </div>
            <div class="splash-spacing">
                <form id="feedback_form" action="/feedback" accept-charset="UTF-8" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="splash-username">Name</label>
                            <input name="username" id="splash-username" required="required" placeholder="Name"
                                class="form-control" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="splash-email">Email</label>
                            <input name="email" id="splash-email" required="required" placeholder="Email"
                                class="form-control" type="email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="splash-message">Message</label>
                            <textarea id="splash-message" required="required" class="form-control contact-message"
                                name="message" placeholder="Message"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <button type="submit" class="col-12 contact--send-button js-send-button">
                                <span class="js-send-feedback">Send</span>
                                <span class="js-feedback-loading contact--feedback-loading"><i
                                        class="fas fa-spinner fa-spin"></i></span>
                            </button>
                            <p class="contact--feedback-confirm js-feedback-confirm">
                                Thanks for your feedback!
                            </p>
                            <p class="contact--feedback-error js-feedback-error">
                                There was an error sending feedback. Please check if all fields are correctly filled and
                                no
                                links are included.
                            </p> <br>
                            <a href="index.php" class="btn btn-primary">Back to Home</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    const feedbackForm = document.getElementById("feedback_form");
    const feedbackButton = document.querySelector(".js-send-button");
    const feedbackLoading = document.querySelector(".js-feedback-loading");
    const feedbackConfirm = document.querySelector(".js-feedback-confirm");
    const feedbackError = document.querySelector(".js-feedback-error");

    feedbackForm.addEventListener("submit", function(e) {
        e.preventDefault();

        // Display loading spinner
        feedbackLoading.style.display = "inline-block";
        feedbackButton.disabled = true;

        // Simulate AJAX request (replace with your actual submission logic)
        setTimeout(function() {
            const success = true; // Replace with your success condition

            if (success) {
                feedbackConfirm.style.display = "block";
            } else {
                feedbackError.style.display = "block";
            }

            // Hide loading spinner
            feedbackLoading.style.display = "none";
            feedbackButton.disabled = false;
        }, 1500);
    });
    </script>
</body>

</html>