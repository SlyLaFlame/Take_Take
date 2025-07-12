<?php
include 'navbar-user.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="styles.css" />
  <title>Features</title>
  <style>
    /* Add CSS styles here */
    .faq-div {
      margin-bottom: 20px;
    }

    .splash-question {
      cursor: pointer;
      display: flex;
      align-items: center;
    }

    .splash-question i {
      margin-right: 10px;
      
    }
    .splash-question:hover  {
      color:blue;
      
    }


    .splash-answer {
      display: none;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h2> <i>FEATURES</i></h2>

  <div class="faq-div">
    <h4 class="splash-question"><i class="fas fa-caret-down"></i> Who are the users of ChessFlame?</h4>
    <p class="splash-answer">ChessFlame is designed to be used by both players and arbiters during chess tournaments. 
      Arbiters create the tournament and add players while players view the pairings and rank after each round</p>
  </div>

  <div class="faq-div">
    <h4 class="splash-question"><i class="fas fa-caret-down"></i> What is the purpose of ChessFlame?</h4>
    <p class="splash-answer">ChessFlame is meant to automate the registration and pairing process of chess players who are into chess in various universities.
       The system also makes the arbiters' lives easier as task are automated. All they need to do is insert the round results and let the system handle the rest! </p>
  </div>

  <div class="faq-div">
    <h4 class="splash-question"><i class="fas fa-caret-down"></i> Is the usage of ChessFlame free?</h4>
    <p class="splash-answer">ChessFlame will always be free to enable competitions and tournaments across universities more interesting and affordable</p>
  </div>

<div class="faq-div">
  <h4 class="splash-question"><i class="fas fa-caret-down"></i> What to do in case of no internet connection?</h4>
  <p class="splash-answer ">In the future we plan adjust ChessFlame to offline usage. For now we recommend to use mobile internet or stable wifi. Chessflame will be designed to work on mobile platforms in future.</p>
</div>

<div class="faq-div">
  <h4 class="splash-question"><i class="fas fa-caret-down"></i> Is there any way to try the application before organising tournament?</h4>
  <p class="splash-answer ">One can use the application as many times as they want as records in the database support updating, deleting and all other CRUD operations</p>
</div>

<div class="faq-div">
  <h4 class="splash-question"><i class="fas fa-caret-down"></i> Is there any hot-line in case of problems?</h4>
  <p class="splash-answer ">Yes, we are online and ready to solve potential problems. You can mail us at <b>nyangateshem22@gmail.com</b> or contact us on <b>0791692009</b></p>
</div>

<div class="faq-div">
  <h4 class="splash-question"><i class="fas fa-caret-down"></i> Is ChessFlame endorsed for chess tournaments?</h4>
  <p class="splash-answer ">ChessFlame is currently being endorsed by ChessKenya once it achieves full functionality.</p>
</div>

  <script>
    // Add JavaScript here
    const questions = document.querySelectorAll('.splash-question');

    questions.forEach((question) => {
      question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        answer.style.display = answer.style.display === 'none' ? 'block' : 'none';
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php
include 'footer.php';
?>
