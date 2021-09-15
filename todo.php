<?php 
session_start();
include("Connection.php");
include("Function.php");
$user_data = check_login($connectionDb);
$user_name = $user_data['user'];
$user_id = $user_data['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
</head>
<body>
    <h3><?php echo "Welcome ".ucfirst($user_name)." Create Your Work List"?></h3>
</body>
</html>