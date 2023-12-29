<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        $con =mysqli_connect("localhost","root","","travel");
        if($con -> connect_errno){
        die ("connection error");
        }
    ?>
</body>
</html>