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
            // Redirect to the login page if not logged in as a passenger
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
    
    ?>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

form {
    max-width: 400px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

img {
    max-width: 100%;
    height: auto;
    margin-bottom: 16px;
    border-radius: 4px;
}

    </style>
   
</head>
<body>

    
   
    
 

   
     <!-- Display additional information about the company -->
    <?php
    $stmtCompanyInfo = $con->prepare("SELECT * FROM passenger WHERE email = ?");
    $stmtCompanyInfo->bind_param('s', $_SESSION['user_email']);
    $stmtCompanyInfo->execute();
    $resultCompanyInfo = $stmtCompanyInfo->get_result();

    if ($resultCompanyInfo->num_rows > 0) {
        $row = $resultCompanyInfo->fetch_assoc();
    } else {

    }

    if(isset($_POST['submit'])) {
        $newName = $_POST['name'];
        $newEmail = $_POST['email'];
        $newPassword = $_POST['password'];
        $newPhone = $_POST['telefone'];
        $newAcount= $_POST['account$'];
        $newLogo = $_POST['photo'];
        $newPassport=$_POST['passport_image'];
        $updateQuery = "UPDATE passenger SET name=?, email=?, telefone=?, password=?, photo=? , passport_image=?,
                     account$=? WHERE email=?";
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->bind_param('ssssssss', $newName, $newEmail, $newPhone, $newPassword,$newLogo,$newPassport, $newAcount, $_SESSION['user_email']);

        $updateStmt->execute();
   
   
        header("Location: ./index.php");
        exit();
    }

     

    //   ';
    ?>

        <form method="post" action="">
            <label for="phone">image:</label>
             <input type="file" id="photo" name="photo" value="<?= $row['photo'] ?>" required>
            
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $row['name'] ?>" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?= $row['email'] ?>" required>

        <label for="email">password:</label>
        <input type="text" id="email" name="password" value="<?= $row['password'] ?>" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="telefone" value="<?= $row['telefone'] ?>" required>
        <label for="phone">balance:</label>
        <input type="number" id="account$" name="account$" value="<?= $row['account$'] ?>" required>
        <label for="phone">passport image:</label>
        <input type="file" id="passport_image" name="passport_image" value="<?= $row['passport_image'] ?>" required>

        <button type="submit" name="submit">Update</button>
        <a href="./index.php">back</a>
    </form>

</body>
</html>