<?php 
session_start();
include("Connection.php");
include("Function.php");
$user_data = check_login($connectionDb);
$user_name = $user_data['user'];
$user_id = $user_data['user_id'];
$todo_name = '';
$update = false;
$id = 0;
$todo_id1='';
$searched = false;

$query = "select * from todos where user_id='$user_id'";
$result = mysqli_query($connectionDb,$query);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['id'] == ''){
        $todo_id1=$_POST['todo'];
        if($todo_id1 && $todo_id1 != ''){
        $query = "select * from todos where id='$todo_id1'";
        $result = mysqli_query($connectionDb,$query);
        $todo_id1=$_POST['todo'];
        $searched = true;
        }
        else{
            echo "enter valid ID plz";
        }
        
        
        
    }
    else{
        if($_POST['id'] == 0){
            $todo_name = $_POST['todo_name'];
            $status = false;
        
            if(!empty($todo_name)){
                $query_todo_store = "insert into todos (user_id,todo_name,status) values('$user_id','$todo_name','$status')";
                $result_todo = mysqli_query($connectionDb,$query_todo_store);
                if($result_todo){
                   header("Location: todo.php");
                }
                else{
                    echo "somthing wrong in storing data";
                }
            }
            else{
                echo "add Todo name first";
            }
        }
        else{
            $todo_name = $_POST['todo_name'];
            $todo_id=$_POST['id'];
            if(!empty($todo_name)){
                $query_todo_name_update = "update todos set todo_name='$todo_name' where id = '$todo_id'";
                $result_todo_name = mysqli_query($connectionDb,$query_todo_name_update);
                if($result_todo_name){
                   header("Location: todo.php");
                }
                else{
                    echo "somthing wrong in updating data";
                }
            }
            else{
                echo "add Todo name first";
            }
        
        }
           
    }

}
if(isset($_GET['status_update'])){
    $todo_id = $_GET['status_update'];
    $status = true;
    if(!empty($todo_id)){
        $query_for_status_update = "update todos set status='$status' where id ='$todo_id'";
        $result_status_update_todo = mysqli_query($connectionDb,$query_for_status_update);
        if($result_status_update_todo){
            header("Location: todo.php");
            die;
        }
        else{
            echo "somthing wrong in data";
        }
    }
    else{
        echo "todo data not valid";
    }
   
}
if(isset($_GET['edit'])){
    $todo_id = $_GET['edit'];
    $query_for_todo_id = "select * from todos where id='$todo_id' limit 1";
    $result_edit_todo = mysqli_query($connectionDb,$query_for_todo_id);
    $data_edit_todo = $result_edit_todo->fetch_array();
    if(count($data_edit_todo)> 0){
        $todo_name = $data_edit_todo['todo_name'];
        $update = true;
        $id = $todo_id;
    }
}
if(isset($_GET['delete'])){
    $todo_id = $_GET['delete'];  
    $query_for_todo_delete = "delete from todos where id = '$todo_id'";
    $result_delete = mysqli_query($connectionDb,$query_for_todo_delete);
    if($result_delete){
        header("Location: todo.php");
        die;
    }
    else{
        echo "somthing happned deleting data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .todo-form-box{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100px;
            margin: 10px auto;
        }
        #todo-input{
            padding: 5px;
        }
        #table-todo{
            width: 75%;
            margin: 0 auto;
        }
        .pages{
            float: right;
        }
        body{
    background: url('./images/photo-1511467687858-23d96c32e4ae.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
    padding: 10px;
}
.search-todo{
    width: 20%;
    margin: 10px auto;
}
.clear-search{
    width: 10%;
    margin: 10px auto;
}
    </style>
</head>
<body>
    <div class="pages">
        <a href="index.php">Home</a>
    <a href="logout.php">Logout</a>
    </div>

    <h3><?php echo "Welcome ".ucfirst($user_name)." Create Your Work List"?></h3>

    <form action="" method="POST">
    <div class="todo-form-box">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="text" name="todo_name" id="todo-input" placeholder="Todo Name" value="<?php echo $todo_name?>">
        <br>
        <?php if($update == true): ?>
        <button type="submit">Update</button>
        <?php else : ?>
            <button type="submit">Add Todo</button>
        <?php endif; ?>
    </div>
    </form>
    <div class="search-todo">
        <form action="" method="POST">
        <input type="hidden" name="id" value="">
            <input type="text" name="todo" id="" value="<?php echo $todo_id1 ?>" placeholder="ID">
            <button type="submit">Search</button>
        </form>
    </div>
    <table class="table table-sm table-striped" id="table-todo">
        <thead>
            <th>ID</th>
            <th>TODO Name</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>
        <?php 
            while ($row = $result->fetch_assoc()): ?>
            <tr>
            <td> <?php echo $row['id'] ?></td>
            <td><?php echo $row['todo_name'] ?></td>
            <?php if($row['status'] == true): ?>
                <td>Completed</td>
            <?php else : ?>
                <td><a href="todo.php?status_update=<?php echo $row['id'] ?>">Not Completed</a></td>
            <?php endif; ?>
            <td>
            <a  href="todo.php?user_id=<?php echo $user_id ?>&edit=<?php echo $row['id'] ?>">Edit</a>
                <a   href="todo.php?user_id=<?php echo $user_id ?>&delete=<?php echo $row['id'] ?>">Delete</a>
            </td>
            </tr>
            
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php if($searched == true) : ?>
        <div class="clear-search">
        <a  href='todo.php'>clear search</a>
        </div>
        
                <?php else: ?>  
                <?php endif; ?>
</body>
</html>