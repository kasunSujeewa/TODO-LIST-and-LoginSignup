<?php 
 session_start();
 include('Connection.php');

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $user_name = $_POST['user_name'];
     $password = $_POST['password'];
     

     if(!empty($user_name) && !empty($password)){
         $query = "select * from users where user = '$user_name' limit 1";
         $result = mysqli_query($connectionDb,$query);

         if($result){
             if($result && mysqli_num_rows($result) > 0){
                 $user_data = mysqli_fetch_assoc($result);
                 if($user_data['password'] === $password){

                    $_SESSION['user_id'] = $user_data['user_id'];
                     header("Location: index.php");
                     die;
                 }
             }
         }
         else{
            echo "enterd password and user name not valid";
         }

     }
     else{
         echo "Form validation failed";
     }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="login-box">
        <form action="" method="POST">
            <h2>Login</h2>
            <input type="text" name="user_name" placeholder="User Name">
            <br>
            <br>
            <input type="password" name="password" id="password" placeholder="Password">
            <br>
            <br>
            <button class="buttonLog" type="submit">Login</button>
            <br>
            <br>
            <a href="Signup.php">Signup</a>
        </form>
    </div>
</body>
</html>