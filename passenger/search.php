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
        font-size: 18;
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
        padding: 16px 18px;
        border-radius: 10px;
        font-family: "Alegreya Sans", sans-serif;
      }
      .btn2 {
        color: white;
        font-size: 18px;
        padding: 16px 18px;
        border-radius: 10px;
        font-family: "Alegreya Sans", sans-serif;
        border: white solid 2px;
        background-color: transparent;
      }

      .contain {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin: 60px 0px;
      }
      .child {
        height: 250px;
        width: 300px;
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
      .search {
        
        background-color:moccasin;

        text-align: center;
        width: 50%;
        margin: 5px auto;
        padding: 50px 0px;
        border: .5px solid black;
        border-radius:10px ;
      }

      select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 200px;
        background-color: white;
        cursor: pointer;
      }

      select::after {
        content: "\25BC"; /* Unicode character for down arrow */
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
      }

      select:hover {
        border-color: #555;
      }
      .temp {
        margin: 15px auto;
        text-align: center;
      }
      .tt1:hover{
        color: red;
      }
    
    </style>
</head>
<body>
<div class="main">
      <div class="navbar" >
        <img class="img" src="../imeges/<?php echo $row['photo']; ?>" alt="passenger photo" />
        <P ><?php echo $row['name']; ?></P>
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
      <?php
        $from=$to="";
    ?>

<div class="search">
        <form method="post" action="search.php">
          <div class="temp">
            <label for="">From :</label>

            <select name="from">
            <option>SELECT</option>
        <?php
        require_once('../connection.php');
        $x="";
        
        $r=$con->query("SELECT * FROM flight  WHERE is_complete='0'");
        while($row=$r->fetch_array(MYSQLI_ASSOC)){
            $x='<option value="'.$row['from'].'">'.$row['from'].'</option>';
            echo $x;

        }
        

        ?>
            </select>
        </br>
    </br>
            <label for="">To :</label>

            <select name="to">
            <option>SELECT</option>
    <?php
    require_once('../connection.php');
        $x="";
        
        $r=$con->query("SELECT * FROM flight WHERE is_complete='0'");
        while($row=$r->fetch_array(MYSQLI_ASSOC)){
            
            $x='<option value="'.$row['to'].'">'.$row['to'].'</option>';
            echo $x;

        }

    ?>
            </select>
          </div>

          <input type="submit" value="search" class="btn1" />
        </form>
      </div>


      <div class="contain">
      <?php

if (isset($_POST['from']) && isset($_POST['to'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];

    
}
$stmt = $con->prepare("SELECT * FROM flight WHERE is_complete='0' AND `from` = ? AND `to` = ?");
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();

while ($x = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '
    <div class="child">
    <h2 class="flightn">
     <a  href="flight.php?from=' . $x['id'] . '" class="tt1">'.$x['name'].'</a>
    </h2>
    <p class="info">iternary: '.$x['Itinerary'].'</p>
    <p class="info">fees :'.$x['fees'].'</p>
    <p class="info">Start at:'.$x['start_at'].'</p>
    <p class="info">Ends at: '.$x['end_at'].'</p>
    <p class="info">From: '.$x['from'].'</p>
    <p class="info">To: '.$x['to'].'</p>
    </div>';
}






?>


      </div>





    

</div>





  


    
</body>
</html>