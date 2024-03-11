<?php  
  
session_start();  
  
if(isset($_POST['submit'])){  
  
   require 'config.php';  

   $tasks = [];
   if(isset($_POST['task_names']) && isset($_POST['task_times'])) {
       $task_names = $_POST['task_names'];
       $task_times = $_POST['task_times'];
       foreach($task_names as $index => $task_name) {
           $task_time = isset($task_times[$index]) ? $task_times[$index] : ''; // If time is not provided, use empty string
           $tasks[] = ['name' => $task_name, 'time_required' => $task_time];
       }
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
         <div id="task_fields">
            <div class="task_field">
               <input type="text" name="task_names[]" required="" class="form-control" placeholder="Task Name">
               <input type="number" name="task_times[]" class="form-control" placeholder="Time required (hours)">
            </div>
         </div>
         <button type="button" id="add_task" class="btn btn-primary">Add Task</button>
      </div>  
      <div class="form-group">  
         <button type="submit" name="submit" class="btn btn-success">Submit</button>  
      </div>  
   </form>  
</div>  

<script>
document.getElementById('add_task').addEventListener('click', function() {
    var taskFields = document.getElementById('task_fields');
    var newTaskField = document.createElement('div');
    newTaskField.classList.add('task_field');
    newTaskField.innerHTML = `
        <input type="text" name="task_names[]" required="" class="form-control" placeholder="Task Name">
        <input type="number" name="task_times[]" class="form-control" placeholder="Time required (hours)">
    `;
    taskFields.appendChild(newTaskField);
});
</script>
  
</body>  
</html>
