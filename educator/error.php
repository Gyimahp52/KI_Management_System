<?php 
session_start();
$educatorEmail = $_SESSION['user_email'];


$testEd = $_SESSION['school_id'];
echo $educatorEmail, $testEd;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>
    NO EDUCATOR FOUND
  </h1>
</body>
</html>