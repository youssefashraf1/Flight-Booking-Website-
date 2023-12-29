<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require_once('../connection.php');
    session_start();
    if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'passenger') {
        header('Location: ../index.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        session_destroy();

        header('Location: ../index.php');
        exit();
    }
    $userEmail = $_SESSION['user_email'];
    $userId=$_SESSION['user_id'];
    $p = $con->query("SELECT * FROM passenger WHERE email = '".$userEmail."'");

        $row=$p->fetch_array(MYSQLI_ASSOC);
    ?>
    <style>
      * {
        padding: 0;
        margin: 0;
      }

      .clr {
        clear: both;
      }
      .navbar {
        background-color: #9f8b5d;
        display: flex;
        align-items: center;
        padding: 10px;
      }

      .img {
        mix-blend-mode: multiply;
        width: 70px;
        height: auto;
        margin-right: 50px;
      }
      .links {
        list-style: none;

        margin: 0;
        padding: 0;
        display: flex;
        right: 10px;
        margin-left: auto;
      }
      .link {
        color: white;

        text-decoration: none;
        font-size: 22px;
        display: block;
        padding: 10px 15px;
        position: relative;
        font-family: "Alegreya", serif;
      }
      .link:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: black;
        transform: scale(0);
        transform-origin: left;
        transition: all 0.5s;
      }
      .link:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: black;
        transform: scale(0);
        transform-origin: right;
        transition: all 0.5s;
      }
      .link:hover {
        color: black;
      }
      .link:hover:before,
      .link:hover:after {
        transform: scaleX(1);
      }
      .tt1 {
        font-size: 30px;
        text-decoration: none;
        color: black;
        font-family: "Alegreya", serif;
      }
      .intro {
        margin: auto;
        text-align: center;
        padding-top: 13%;
        padding-bottom: 28%;
      }
      h1 {
        color: white;

        margin-bottom: 40px;
        margin-top: 20px;
        font-family: "Alegreya", serif;
        font-size: 70px;
      }

      p {
        color: white;

        font-size: 20px;
        font-family: "Alegreya Sans", sans-serif;
      }

      
      .message-tab {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
      }

      h2 {
        margin-bottom: 10px;
      }

      #company-select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
      }

      #message-text {
        width: 100%;
        height: 150px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;
      }

      #send-button {
        background-color: #9f8b5d; 
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        margin-top: 10px;
      }
      .contain{
        width: 70%;
        margin: 0px auto;
        margin-top: 40px;
        padding: 20px 0px;
        
      }
      .tt1{
        font-size: 18;
         text-decoration: none;
        color: white;
         font-family: "Alegreya", serif;
}
.tt1:hover{
        color: red;
      }
      .site-footer {
        background-color: #26272b;
        padding: 45px 0 20px;
        font-size: 15px;
        line-height: 24px;
        color: #737373;
      }
      .site-footer hr {
        border-top-color: #bbb;
        opacity: 0.5;
      }
      .site-footer hr.small {
        margin: 20px 0;
      }
      .site-footer h6 {
        color: #fff;
        font-size: 16px;
        text-transform: uppercase;
        margin-top: 5px;
        letter-spacing: 2px;
      }
      .site-footer a {
        color: #737373;
      }

      .footer-links,
      .footer-links li a {
        padding-left: 0;
        list-style: none;
        text-decoration: none;
      }
      .container {
  display: flex;  
  justify-content: space-between; 
}

@media (max-width: 768px) {
  .child {
    width: 50%; 
  }
}

     
    </style>
</head>
<body>
<?php
$flightId = $payment = '';

if (isset($_GET['flightId']) && isset($_POST['paymentType'])) {
    $flightId = $_GET['flightId'];
    $payment = $_POST['paymentType'];

    $checkExisting = $con->query("SELECT * FROM passenger_flight WHERE flight_id = '$flightId' AND user_email = '$userEmail'");
    if ($checkExisting->num_rows > 0) {
        echo "Flight is already reserved by the user.";
        exit();
    } else {
        $row = null;
        $query = "SELECT * FROM flight WHERE id = '$flightId'";
        $result = $con->query($query);

        if ($result === false) {
            echo "Error executing query: " . $con->error;
        } else {
            if ($result->num_rows > 0) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
            }else{
                echo "Flight not found";
                exit();

            }

        
                
            

            if ($payment === 'fromAccount') {
                $checkbalance = $con->query("SELECT account$ FROM passenger WHERE id=$userId");
                $checkit = $checkbalance->fetch_array(MYSQLI_ASSOC);

                if ($checkit['account$'] >= $row['fees']) {
                    $r2 = $con->query("UPDATE passenger SET account$ = account$ -" . $row['fees'] . " WHERE id=" . $userId . "");
                    $r3 = $con->query("UPDATE company SET account$ = account$ + " . $row['fees'] . " WHERE email='" . $row['company_email'] . "'");

                    if ($r2 === false || $r3 === false) {
                        echo "Failed to update balances: " . $con->error;
                        exit();
                    }
                    $fees=$row['fees'];

                    $r4 = $con->query("INSERT IGNORE INTO passenger_flight (flight_id, user_email ,is_paid,fees) VALUES ('$flightId', '$userEmail','1','$fees')");
                    if ($r4 === false) {
                        if ($con->errno == 1062) { // MySQL error code for duplicate entry
                            echo "Flight is reserved before.";
                        } else {
                            echo "Failed to reserve the flight: " . $con->error;
                        }
                        exit();
                    }

                    $r5 = $con->query("UPDATE flight SET registered_num =registered_num +1 WHERE id='$flightId'");
                } else {
                    echo "Sorry!! ,You don't have enough money in your account balance";
                    exit();
                }
            } elseif ($payment === 'cash') {
                $fees=$row['fees'];
                $r4 = $con->query("INSERT IGNORE INTO passenger_flight (flight_id, user_email ,is_paid,fees) VALUES ('$flightId', '$userEmail','0','$fees')");
                if ($r4 === false) {
                    if ($con->errno == 1062) { // MySQL error code for duplicate entry
                        echo "Flight is reserved before.";
                    } else {
                        echo "Failed to reserve the flight: " . $con->error;
                    }
                    exit();
                }

                $r5 = $con->query("UPDATE flight SET registered_num =registered_num +1 WHERE id='$flightId'");
            }
            // header("Location: index.php");

        }
    }
}

?>

<div class="main">
      <div class="navbar">
      <img class="img" src="../imeges/<?php echo $row['photo']; ?>" alt="passenger icon" />
        <P><?php echo $row['name']; ?></P>
        <ul class="links">
        <li><a href="profile.php" class="link">Profile</a></li>
        <li><a href="search.php" class="link">Search a Flight</a></li>
        <li><a href="listComplite.php" class="link">Complete flight</a></li>
        <li><a href="current.php" class="link">current flight</a></li>
        <li><a href="message.php" class="link">Message A Company</a></li>
          <li>
            <form method="post">
              <button
                type="submit"
                name="logout"
                class="link"
                style="background: none; border: none"
              >
                Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
      <div class="contain">

      
      </div>


      
        
      </div>
    </div>


<form method="post" action="">
<h2>PaymentType:</h2>
<form method="post" action="#">
                <div class="message-tab">
                <h2>Select Company:</h2>
                <select id="company-select"  name="paymentType">
             
            <option value="fromAccount" <?= $payment=== 'fromAccount' ? 'selected' : ''; ?>>  From Account</option>
            <option value="cash" <?= $payment=== 'cash' ? 'selected' : ''; ?>> Cash</option>
        </select>
    
    <input type="submit"  id="send-button"  value="CheckOut">

</form>

</body>
</html>