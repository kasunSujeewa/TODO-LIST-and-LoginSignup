<?php
session_start();
include("Connection.php");
include("Function.php");

$user_data = check_login($connectionDb);
$user_name = $user_data['user'];
$user_id = $user_data['user_id'];

$query = "select * from details where user_id ='$user_id' limit 1";
$result = mysqli_query($connectionDb,$query);
$details = $result->fetch_array();

$editable = false;

if(isset($_GET['edit'])){
    $editable = true;    
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $hobby = $_POST['hobby'];
    $gender = $_POST['gender'];
    $school = $_POST['school'];
    if(!empty($user_id) && !empty($user_name) && !empty($age) && !empty($address) && !empty($hobby) && !empty($school) && !empty($gender)){
        $query_for_user_update = "update users set user='$user_name' where user_id='$user_id'";
        mysqli_query($connectionDb,$query_for_user_update);

        $query_for_details_updating = "update details set age='$age',address='$address',hobby='$hobby',gender='$gender',school='$school' where user_id='$user_id'";
        mysqli_query($connectionDb,$query_for_details_updating);

        header("Location: index.php");
        die;
    }
    else{
        echo "check all fields again and update";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($user_name)  ?></title>
    <style>
.user-details-box{
    display: flex;
    flex-direction: column;
    width: 60%;
    margin: 0 auto;
    padding: 33px;
    align-items: center;
    border: 2px solid #ae1515;
    background: linear-gradient(
45deg, #6d4a9b, transparent);
}
#form-input{
    padding: 5px;
    width: 40%;
    margin: 10px 0;
}
#form-select{
    padding: 5px;
    width: 20%;
    margin: 10px 0;
}
.pages{
    float:right;
}
body{
    background: url('./images/top-view-work-from-home-concept-with-keyboard-calculator-notebook-white-background-graphic-designer-creative-designer-concept_160097-217.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    padding: 10px;
}

    </style>
</head>
<body>
    <div class="pages">
        <a href="todo.php">Todo Page</a>
    <a href="logout.php">Logout</a>
    </div>
   

    <h2><?php echo "Welcome ".ucfirst($user_name) ?></h2>
    <br>
    <br>
    <?php if($editable == false) : ?>
    <div class="user-details-box">
        <label >Name :</label>
        <h2><?php echo ucfirst($user_name) ?></h2>
        <label >Age :</label>
        <h2><?php echo $details['age'] ?></h2>
        <label >Address :</label>
        <h2><?php echo ucfirst($details['address']) ?></h2>
        <label >Gender :</label>
        <h2><?php echo ucfirst($details['gender']) ?></h2>
        <label >School :</label>
        <h2><?php echo ucfirst($details['school']) ?></h2>
        <label >Hobby :</label>
        <h2><?php echo ucfirst($details['hobby']) ?></h2>
        <a href="index.php?edit=<?php echo $user_id ?> ">EDIT</a>
    </div>
    <?php else : ?>
        <form action="" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
        <div class="user-details-box">
        <label >Name :</label>
        <input type="text" name="user_name" id="form-input" value="<?php echo ucfirst($user_name) ?>">
        <label >Age :</label>
        <input type="text" name="age" id="form-input" value="<?php echo $details['age'] ?>">
        <label >Address :</label>
        <input type="text" name="address" id="form-input" value="<?php echo ucfirst($details['address']) ?>">
        <label >School :</label>
        <input type="text" name="school" id="form-input" value="<?php echo ucfirst($details['school']) ?>">
        <label >Hobby :</label>
        <input type="text" name="hobby" id="form-input" value="<?php echo ucfirst($details['hobby']) ?>">
        <select name="gender" id="form-select">
        <label >Gender :</label>
            <?php if($details['gender'] == 'male'): ?>
                <option value="male" selected>Male</option>
            <?php else: ?>
                <option value="male" >Male</option>
            <?php endif; ?>
            <?php if($details['gender'] == 'female'): ?>
                <option value="female" selected>Female</option>
            <?php else: ?>
                <option value="female">Female</option>
            <?php endif; ?>          
        </select>
        <button type="submit">Update</button>
    </div>
    </form>
    <?php endif; ?>

</body>
</html>