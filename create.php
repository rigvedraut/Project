<?php  
  
session_start();  
  
if(isset($_POST['submit'])){  
  
   require 'config.php';  
  
   $tasks = $_POST['tasks'];

   if (!is_array($tasks)) {
       $tasks = array($tasks);
   }

   $insertOneResult = $collection->insertOne([  
       'code' => $_POST['code'],  
       'name' => $_POST['name'],  
       'tasks' => $tasks,
   ]);  
  
   $_SESSION['success'] = "Creation of Project is successful";  
   header("Location: index.php");  
}  
  
?>  
  
<!DOCTYPE html>  
<html>  
<head>  
   <title> CRUD Operation using MongoDB and PHP </title>  
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">  
   <link href="create.css" rel="stylesheet">

</head>  
<body>  
  
<div class="container">  
   <h1>Create Project</h1>  
   <a href="index.php" class="btn btn-primary">Back</a>  
  
   <form method="POST">  
      <div class="form-group">  
         <strong>Code:</strong>  
         <input type="text" name="code" required="" class="form-control" placeholder="Project Code">  
      </div> 
      <div class="form-group">  
         <strong>Name:</strong>  
         <input type="text" name="name" required="" class="form-control" placeholder="Project Name">  
      </div>  
      <div class="form-group">  
         <strong>Tasks:</strong>  
         <textarea class="form-control" name="tasks" placeholder="Project Tasks" placeholder="Project Tasks"></textarea>  
      </div>  
      <div class="form-group">  
         <button type="submit" name="submit" class="btn btn-success">Submit</button>  
      </div>  
   </form>  
</div>  
  
</body>  
</html>  
