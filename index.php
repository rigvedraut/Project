<?php  
session_start();  
?>  
<!DOCTYPE html>  
<html>  
<head>  
   <title>Project and Task Management</title>  
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">  
   <link href="index.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


</head>  
<body>  

<div class="container">  
<h1>Project Management</h1>  

<a href="create.php" class="btn btn-success">Add Project</a>  

<?php  
if(isset($_SESSION['success'])){  
    echo "<div class='alert alert-success'>".$_SESSION['success']."</div>";  
}  
?>  

<!-- form -->
<form method="GET" action="index.php" class="form-inline"> 
    <div class="form-group">
        <input type="text" name="search_code" class="form-control" placeholder="Search by Code">
    </div>
    <div class="form-group">
        <input type="text" name="search_name" class="form-control" placeholder="Search by Name">
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<table class="table table-bordered">  
   <tr>  
      <th>Project Code</th>  
      <th>Project Name</th>  
      <th>Tasks</th>
      <th>Action</th>  
   </tr>  
   <?php  
   require 'config.php';  

   $filter = [];
   if (isset($_GET['search_code']) && $_GET['search_code'] !== '') {
       $filter['code'] = new MongoDB\BSON\Regex($_GET['search_code'], 'i');
   }
   if (isset($_GET['search_name']) && $_GET['search_name'] !== '') {
       $filter['name'] = new MongoDB\BSON\Regex($_GET['search_name'], 'i');
   }

   $projects = $collection->find($filter);  

   foreach($projects as $project) {  
      echo "<tr>";  
      echo "<td>".$project->code."</td>";  
      echo "<td>".$project->name."</td>";  
      echo "<td>";  
      foreach ($project->tasks as $task) {
          echo "<div>$task->name - Time required: $task->time_required hours</div>";
      }
      echo "</td>";
      echo "<td>";  
      echo "<a href='edit.php?id=".$project->_id."' class='btn btn-primary'><i class='fas fa-edit'></i></a>"; // Edit button with icon
      echo "<a href='delete.php?id=".$project->_id."' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this project?');\"><i class='fas fa-trash'></i></a>"; // Delete button with icon
      echo "</td>";  
      echo "</tr>";  
   };  
   ?>  
</table>  
</div>  
<script>
// Hide success message after 4 seconds
setTimeout(function() {
    var successMessage = document.getElementById('successMessage');
    if (successMessage) {
        successMessage.style.display = 'none';
    }
}, 4000);
</script>

</body>  
</html>  
