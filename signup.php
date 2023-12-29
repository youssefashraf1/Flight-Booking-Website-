<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
        require_once('./connection.php');
        include('./connection.php');
?>
<style>
    /* General styling */
body {
  font-family: sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f5f5; /* Light gray background */
}

.fo {
  background-color: #fff; /* White background */
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  width: 400px; /* Adjust for desired width */
}

/* Form styling */
label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

input[type="text"],
input[type="password"],
input[type="telephone"],
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
  box-sizing: border-box;
}

.sub {
  background-color: #4CAF50; 
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.back {
  text-decoration: none;
  color: #333;
  margin-left: 10px;
}
.fo {
  animation: slideInRight 1s ease-in-out;
}

@keyframes slideInRight {
  from { transform: translateX(-100%); }
  to { transform: translateX(0); }
}




</style>
</head>
<body>
    <?php
        $email = $name = $password = $tel = $type = '';
        $errors = [];
    ?>
     <div class="fo">
     <form method="post" action="">
            <label>Email:</label>
            <input type="text" name="email" value="">
            <label>Name:<input type="text" name="name" value=""></label>
            <label>Password:<input type="password" name="password" value=""></label>
            <label>Telephone:<input type="telephone" name="tel" value=""></label>
            <label>Type:
                <select name="type">
                    <option value="company" <?= $type=== 'company' ? 'selected' : ''; ?>>  Company</option>
                    <option value="passenger" <?= $type=== 'passenger' ? 'selected' : ''; ?>> Passenger</option>
                </select>
        </label>
        <br>
            <input type="submit" name="register" value="SignUp" class="sub">
            <a href="index.php" class="back">Back to login</a>
        </form>
     </div>
       
     <?php

    
if( isset($_POST['name'])&&
    isset($_POST['email'])&&
    isset($_POST['password'])&&
    isset($_POST['tel'])&&
    isset($_POST['type']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $tel=$_POST['tel'];
    $type=$_POST['type'];
    if($type === 'company'){

        header("Location: Company.php?name=$name&email=$email&password=$password&tel=$tel");
    }
    elseif($type === 'passenger'){

        header("Location: Passenger.php?name=$name&email=$email&password=$password&tel=$tel");

    }
    exit();
}
?>
</body>
</html>