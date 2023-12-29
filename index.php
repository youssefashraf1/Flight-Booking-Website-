<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require_once('./connection.php');
    ?>
<style>
  body {
  background-image: url(login\ background.jpeg);

  background-size: cover;
  background-position: center center;
}

body {
  font-family: sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f5f5; 
}

.photo {
  background-size: cover;
  width: 100%;
  height: 500px;
  position: relative;
}

.login-container {
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.005);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 80px 100px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
   
}



h1 {
  font-size: 40px;
  text-align: center;
  margin-bottom: 20px;
  font-weight: bold;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="email"],
input[type="password"],
select {
  width: 100%;
  padding: 10px 40px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
  box-sizing: border-box;
}

button {
 

  background-color: #3e00ff; 
  color: white;
  padding: 10px 40px;
  margin-right:20px ;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin: 0px auto;
}



.tt1 {
  margin: 0px auto;
  padding: 35px;
        color: black;
        font-size: 20px;
        text-decoration: none;
        font-family: "Alegreya", serif;
      }




</style>    
    
</head>
<body>
<?php
        $email = $name = $password = $tel = $type = '';
        $errors = [];
    ?>


  

<div class="photo">
    <div class="login-container">
        <h1>Login</h1>
        <form method="post" action="index.php">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />

            <label for="type">Type</label>
            <select name="type">
                    <option value="company" <?= $type=== 'company' ? 'selected' : ''; ?>>  Company</option>
                    <option value="user" <?= $type=== 'user' ? 'selected' : ''; ?>> user</option>
            </select>

            <button type="submit" class="button" id="login-btn">Login</button>
        </form>
    </br>
        <a  class="tt1" href="signup.php">
              Don't have an email?
            </a
        >
    </div>
</div>

    <?php
        session_start();
        $email =$password=$type ="";
        $errors = [];
        if(isset($_POST['email']) &&
            isset($_POST['password']) &&
            isset($_POST['type']))
        {
            $email=$_POST['email'];
            $password=$_POST['password'];
            $type=$_POST['type'];
        }
        if ($type === "user") {
            $PassengerQuery = $con->prepare("SELECT * FROM passenger WHERE email = ?");
            $PassengerQuery->bind_param('s', $email);
            $PassengerQuery->execute();
            $resultPassenger = $PassengerQuery->get_result();
            if ($resultPassenger->num_rows > 0) {
                $user = $resultPassenger->fetch_assoc();
                if ($password=== $user['password']) {
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_type'] = 'passenger';
                    header('Location: passenger/index.php');
                    exit();
                } else {
                    echo "Incorrect password!";
                }
            }
        }elseif ($type === "company"){
            $CompanyQuery = $con->prepare("SELECT * FROM company WHERE email = ?");
            $CompanyQuery->bind_param('s', $email);
            $CompanyQuery->execute();

            $resultCompany = $CompanyQuery->get_result();
            if ($resultCompany->num_rows > 0) {
                $user = $resultCompany->fetch_assoc();

                if ($password===$user['password']) {
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_type'] = 'company';
                    header('Location: company/index.php');
                    exit();
                } else {
                    echo "Incorrect password!";
                }
            }
        }
    ?>
</body>
</html>