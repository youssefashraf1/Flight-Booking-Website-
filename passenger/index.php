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
      .main{
        background-image: url(../imeges/background.jpeg);    
        background-size: cover;
        background-position: center center;
        height: 100vh;
        }
      
.clr {
  clear: both;
}
.navbar {
      background-color: white; 
      display: flex;
      align-items: center;
      padding: 10px;
    }

.img {
    width: 70px; 
      height: auto;
      margin-right: 50px;
      
}
.links {
    list-style: none;
    
    margin: 0 ;
      padding: 0;
      display: flex;
      right: 10px;
      margin-left: auto; 


}
.link {
        color: #9f8b5d;
        
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
.tt1{
    font-size: 18;
  text-decoration: none;
  color: white;
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
.about-decs {
        width: 40%;
      }

      .padding {
        width: 75%;
      }

      .contain img {
        width: 100%;
        height: 450px;
      }
      .about-photo {
        float: left;
        width: 360px;
        height: 440px;
        border: 7px gray solid;
        border-radius: 2%;
        position: relative;
        left: 120px;
      }
      .contain .about-decs {
        float: left;
      }

      .contain {
        top: 20px;
        left: 20px;
        position: relative;
        overflow: hidden;
      }

      .about-decs {
        width: 50%;
        float: left;
        position: absolute;
        right: 50px;
        padding: 0px 50px 50px;
      }

      .hello {
        margin-top: 10px;
        position: relative;
        padding-left: 5px;
      }
      .hello::before {
        content: "";
        background-color: #9f8b5d;
        width: 5px;
        height: 25px;
        left: 0px;
        top: 10px;
        position: absolute;
      }
      .about-p {
        color: black;
        padding: 50px 20px;
      }
      span {
        color: gray;
      }
      .about {
        margin: 50px 0px;
      }
      .clr {
        clear: both;
      }
      .about{
        padding-bottom: 200px;
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
      <div class="navbar" >
        <img class="img" src="../imeges/<?php echo $row['photo']; ?>" alt="passenger photo" />
        <P style="color:#8e7754;"><?php echo $row['name']; ?></P>
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


      <div class="intro">
        <p>Welcome</p>
        <h1><?php echo $row['email']; ?></h1>
        <p>haven't you reserve your ticket yet? </br> now you can reserve and search for the flight you want</p>
        <div class="buttons">
        <button class="btn1"><a href="current.php" class="tt1">See your Flight</a></button>
        </div>
    </div>

    <div class="about">
      <div class="about-photo">
        <div class="contain">
          <img src="../imeges/crew.jpg" alt="" />
        </div>
      </div>
      <div class="about-decs">
        <div class="hello">
          <h2>HELLO,to out website</h2>
        </div>
        <p class="about-p">
          At this travel company, we provide the best in flight services. Our
          team of experts will help you find the best and most affordable
          flights, from domestic to international, so you can enjoy your trip
          with ease. We offer a variety of airline options to choose from as
          well as flexible booking options. With our dedicated customer service
          staff, we make sure that all your flight related queries are answered
          promptly and professionally. Book with us today for a hassle-free
          journey!
        </p>
      </div>
      <div class="clr"></div>
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