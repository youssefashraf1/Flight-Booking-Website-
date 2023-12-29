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
        $q = $con->query("SELECT * FROM passenger WHERE email = '".$userEmail."'");

    $row=$q->fetch_array(MYSQLI_ASSOC);
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

<div class="main">
      <div class="navbar">
      <img class="img" src="../imeges/<?php echo $row['photo']; ?>" alt="passenger icon" />
        <P><a href="./index.php" class="tt1"><?php echo $row['name']; ?></a></P>
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
      <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['send_message']) 
            && isset($_POST['company_id']) 
            && isset($_POST['message']) ){
               $b=$con->query("SELECT * FROM passenger WHERE id=$userId");
               $k=$b->fetch_array(MYSQLI_ASSOC);
               $passname=$k['name'];
                $companyId=$_POST['company_id'];
                
                $message=$_POST['message'];
                $r2=$con->query("INSERT INTO message ( passenger_id,passenger_name,company_id, message) VALUES ( $userId,'$passname',$companyId, '$message')");
                if ($r2 === true) {
                    echo "<h2>Message sent successfully!</h2>";
                } else {
                    echo "Failed to send message: " . $con->error;
                }
            }
        }



         $r=$con->query("SELECT id , name FROM company");
         if ($r === false) {
             echo "Failed to fetch companies: " . $con->error;
            } else{
                echo '
                <form method="post" action="#">
                <div class="message-tab">
                <h2>Select Company:</h2>
                <select id="company-select" name="company_id">
                <option value="">Select a company</option>
            ';
            while($row=$r->fetch_array(MYSQLI_ASSOC)){
                echo '
                <option value="' . $row['id'] . '">' . $row['name'] . '</option>
                ';
            }   
            echo '    </select>
                <textarea name="message" id="message-text"
                placeholder="Write your message here..."></textarea>
                <input type="submit" name="send_message" id="send-button" value="Send Message">
                </div>
                </form>
                ';
        }
    ?>
</div>

      
      
<footer class="site-footer">
    <div class="container">
  <div class="mini child">
    <h6>About</h6>
    <p style="color:gray;">
      At this travel company, we provide the best in flight services. </br>Our team of experts will help you find the best and most </br>affordable flights, from domestic to international, so you can enjoy your trip with ease.</br> We offer a variety of airline options to choose from as well as flexible booking options.</br> With our dedicated customer service staff, we make sure that all your flight related</br> queries are answered promptly and professionally. Book with us today for a hassle-free journey!
    </p>
  </div>

  <div class="child">
    <h6>Quick Links</h6>
    <ul class="footer-links">
      <li><a href="">About Us</a></li>
      <li><a href="">Contact Us</a></li>
      <li><a href="">Contribute</a></li>
      <li><a href="">Privacy Policy</a></li>
      <li><a href="">Sitemap</a></li>
    </ul>
  </div>

  <hr />

</div>

    </footer>
      
    </div>

  

  
</body>
</html>