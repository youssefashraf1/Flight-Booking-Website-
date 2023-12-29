<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        require_once('../connection.php');
        session_start();
        if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'passenger') {
            // Redirect to the login page if not logged in as a company
            header('Location: ../index.php');
            exit();
        }
        if (isset($_POST['logout'])) {
            // Destroy the session
            session_destroy();

            // Redirect to the login page
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
        font-size: 25px;
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

      .buttons {
        margin-top: 2.5%;
      }
      .btn1 {
        color: white;
        font-size: 18px;
        background-color: #8e7754;
        border: none;
        padding: 8px 8px;
        border-radius: 10px;
        font-family: "Alegreya Sans", sans-serif;
        margin-left: 95px;

      }
      .btn2 {
        color: white;
        font-size: 18px;
        padding: 8px 8px;
        border-radius: 10px;
        font-family: "Alegreya Sans", sans-serif;
        border: white solid 2px;
        background-color: transparent;
        margin-left: 120px;
      }

      .contain {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin: 60px 0px;
      }
      .child {
        height: 300px;
        width: 350px;
        background-color: burlywood;
        margin: 15px;
        border-radius: 15px;
      }
      .flightn {
        margin: 20px auto;
        text-align: center;
      }
      .info {
        margin-left: 30px;
        color: black;
      }
     
      .tt1:hover{
        color: red;
      }
    </style>
</head>
<body>

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
      <div class="diclration">
        <h1 class="dic">Your Flights</h1>
      </div>

      <div class="contain">
     

      

    <?php
       if (isset($_GET['from']) && $_GET['from'] !== '') {
        $flightId = $_GET['from'];
        $query = "SELECT * FROM flight WHERE id = $flightId";
        $result = $con->query($query);
    
        if ($result === false) {
            echo "Error executing query: " . $con->error;
        } else {
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $id=$row['id'];
                echo '
                    <form method="post" action="reserve.php?flightId='.$_GET['from'].'">
                    <div class="child">
                 <h2 class="flightn">
                 <a  href="./flight.php?from='.$row['id'].' & companyId='.$row['company_email'].'" class="tt1">'.$row['name'].'</a>
                </h2>
                <p class="info">iternary: '.$row['Itinerary'].'</p>
                <p class="info">fees :'.$row['fees'].'</p>
                <p class="info">Start at:'.$row['start_at'].'</p>
                 <p class="info">Ends at: '.$row['end_at'].'</p>
                     <p class="info">From: '.$row['from'].'</p>
                 <p class="info">To: '.$row['to'].'</p>
                 </br>
                 <input type="submit" class="btn2" value="take it?">

                 </div>  
                    

                    


                    </form>
                    
                    ';

                } else {
                
                    echo "No rows found for flight ID: $flightId";
                }


            }
        }
        ?>











      
        
      </div>
    </div>

 
         
        
</body>
</html>