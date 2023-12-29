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

input , a {
  width: 100%;
  padding: 8px;
  margin-bottom: 16px;
  box-sizing: border-box;
}

/* a {
  background-color: #4caf50;
  color: #fff;
  cursor: pointer;
}
a:hover {
  background-color: #45a049;
} */
.d {
  animation: slideInRight 1s ease-in-out;
}

@keyframes slideInRight {
  from { transform: translateX(-100%); }
  to { transform: translateX(0); }
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

    </style>
</head>
<body>

<?php
        $errors=[];
    
        $name=$_GET['name'];
        $email=$_GET['email'];
        $password=$_GET['password'];
        $tel=$_GET['tel'];
        if(
            isset($_POST['photo'])&&
            isset($_POST['passportImg'])&&
            isset($_POST['accountNumber'])
        ){
    
    
            $photo = $_POST['photo'];
            $passportImg = $_POST['passportImg'];
            $accountNumber=$_POST['accountNumber'];
           
            $r = $con->query("INSERT INTO passenger VALUES (null,'$name','$email','$tel','$password','$photo','$passportImg','$accountNumber')");
            if ($con->affected_rows == 0){
                $errors[ "data"] ="faild";
            }
            header('Location: index.php');
    
        }
    ?>
    
        



    <div class="d">
      <h1>Passenger Information Form</h1>
      <form method="post" action="#" ">
      <label for="photo">Photo Image:</label>
      <input type="file" id="photo" name="photo" accept="image/*" required />

      <label for="passport">Passport Image:</label>
      <input
        type="file"
        id="passport"
        name="passportImg"
        accept="image/*"
        required
      />

      <label for="accountNumber">Account Income Number:</label>
      <input type="number" id="accountNumber" name="accountNumber" required />
      <input type="submit" class="sub" value="submit">
        <a href="./signup.php" class="back">Back</a>

      </form >
    </div>


</body>
</html>