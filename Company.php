<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        require_once('./connection.php');
    ?>
    <style>
        body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.d {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 8px;
}

input,
textarea {
  width: 100%;
  padding: 8px;
  margin-bottom: 16px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #4caf50;
  color: #fff;
  cursor: pointer;
}
.back {
  text-decoration: none;
  color: #333;
  margin-left: 10px;
}

.sub {
  background-color: #4CAF50; 
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.d {
  animation: slideInRight 1s ease-in-out;
}

@keyframes slideInRight {
  from { transform: translateX(-100%); }
  to { transform: translateX(0); }
}

    </style>
</head>
<body>
    
<div class="d">
      <h1>Company Information Form</h1>
      <form method="post" action="#" >
    <label for="logo">Logo Image:</label>
      <input type="file" id="logo" name="logoImg"  accept="image/*" required />

      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required />

      <label for="address">Address:</label>
      <input type="text" id="address" name="address" required />

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required />

      <label for="bio">Bio:</label>
      <textarea id="bio" name="bio" rows="5" required></textarea>

      <label for="accountNumber">Account Income Number:</label>
      <input type="number" id="accountNumber" name="accountNumber" required />

        <input type="submit" class="sub" value="submit">
        <a href="./signup.php" class="back">Back</a>
        


    </form>
   
    </div>
    
    
    
    <?php
        $errors=[];

        $name=$_GET['name'];
        $email=$_GET['email'];
        $password=$_GET['password'];
        $tel=$_GET['tel'];
        if(
            isset($_POST['username'])&&
            isset($_POST['location'])&&
            isset($_POST['address'])&&
            isset($_POST['bio'])&&
            isset($_POST['logoImg'])&&
            isset($_POST['accountNumber'])
        ){
            $username = $_POST['username'];
            $location = $_POST['location'];
            $address = $_POST['address'];
            $bio = $_POST['bio'];
            $logoImg = $_POST['logoImg'];
            $accountNumber=$_POST['accountNumber'];
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errors['email']='Invalid email address';
            }
            $r = $con->query(
                "INSERT INTO company VALUES (null,'$name','$username','$email','$password','$tel','$bio','$address'
                        ,'$location','$logoImg','$accountNumber')");
            if ($con->affected_rows == 0){
                echo "faild" .$con->error;
            }
            header('Location: index.php');
        }
    ?>




</body>
</html>