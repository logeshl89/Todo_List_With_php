<?php
$SERVER="localhost";
$username="root";
$database="todolist";
$conn=mysqli_connect($SERVER,$username,"",$database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['add'])){ 
  $item = $_POST['item'];
  
  if(!empty($item)){
      $query = "INSERT INTO tasks (name) VALUES ('$item')";
      if(!mysqli_query($conn, $query)){
          die("Error: " . mysqli_error($conn));
      } else {
          echo '
          <center>
          <div class="alert alert-success" role="alert"> Item Added Successfully!
          </div>
          </center>';
      }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todo List Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLh" />
    <link rel="stylesheet" href="custome_style.css">
</head>

<body>
<main>
    <div class="container">
        <div class="row">
            <div class="card"></div>
            <div class="card box">
                <div class="card">
                    <div class="card-header">
                        <h1>Todo List</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="item" placeholder="Add a Todo Item" />
                            </div>
                            <input type="submit" class="buttonadd" name="add" value="Add Item" />
                        </form>
                        <?php
                        $query = "SELECT * FROM tasks";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $itemName = $row['name'];
                                $itemStatus = $row['status'];
                                $itemClass = ($itemStatus == 1) ? 'done' : '';
                                echo '
                                    <div class="rowes">
                                        <div class="one"><h5>'.$i.'</h5></div>
                                        <div class="three"><h5 class="'.$itemClass.'">'.$itemName.'</h5></div>
                                        <div class="four">
                                            <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark buttons-make">Mark as Done</a>
                                            <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                        </div>
                                    </div>';
                                $i++;
                            }
                        } else {

                            echo '
                                <center>
                                    <img src="Image1.png" width="50px" alt="Empty List"><br>
                                    <span>Your List is Empty</span>
                                </center>';
                        }

                        if(isset($_GET['action'])){
                          $itemId = $_GET['item'];
                          if($_GET['action'] == 'done'){
                            $query = "UPDATE tasks SET status = 1 WHERE id = '$itemId'";
                            if (mysqli_query($conn, $query)){
                              echo '<div class="alert alert-info" role="alert">
                                      <center>
                                        Item Marked as Done!
                                      </center>
                                    </div>';
                            } else {
                              echo mysqli_error($conn);
                            }
                          }elseif ($_GET['action'] == 'delete') {
                            
                            $itemId = $_GET['item'];
                            $query = "DELETE FROM tasks WHERE id = '$itemId'";
                            if (mysqli_query($conn, $query)) {
                                echo '
                                    <center>
                                        <div class="alert" >
                                            Item Deleted Successfully!
                                        </div>
                                    </center>';
                            }
                        }
                        }
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
</script> 
</body>
</html> 