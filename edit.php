<?php
session_start();

if(isset($_POST['submit'])){
    require 'config.php';  

    $tasks = [];
    if(isset($_POST['task_names']) && isset($_POST['task_times'])) {
        $task_names = $_POST['task_names'];
        $task_times = $_POST['task_times'];
        foreach($task_names as $index => $task_name) {
            $task_time = isset($task_times[$index]) ? $task_times[$index] : '';
            $tasks[] = ['name' => $task_name, 'time_required' => $task_time];
        }
    }

    $updateResult = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectID($_GET['id'])], 
        ['$set' => [
            'code' => $_POST['code'],  
            'name' => $_POST['name'],  
            'tasks' => $tasks
        ]]
    );

    if($updateResult->getModifiedCount() > 0) {
        $_SESSION['success'] = "Project updated successfully";
    } else {
        $_SESSION['error'] = "Failed to update project";
    }

    header("Location: index.php");
    exit();
}

require 'config.php';

$project = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]); 
?>

<!DOCTYPE html>
<html>
<head>
   <title>Edit Project</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
   <link href="create.css" rel="stylesheet">
</head>
<body>

<div class="container">
   <h1>Edit Project</h1>
   <a href="index.php" class="btn btn-primary">Back</a>

   <form method="POST">
      <div class="form-group">
         <strong>Code:</strong>
         <input type="text" name="code" required="" class="form-control" placeholder="Project Code" value="<?php echo $project->code; ?>">
      </div>
      <div class="form-group">
         <strong>Name:</strong>
         <input type="text" name="name" required="" class="form-control" placeholder="Project Name" value="<?php echo $project->name; ?>">
      </div>
      <div class="form-group">
         <strong>Tasks:</strong>
         <div id="task_fields">
            <?php foreach($project->tasks as $task): ?>
                <div class="task_field">
                    <input type="text" name="task_names[]" required="" class="form-control" placeholder="Task Name" value="<?php echo $task->name; ?>">
                    <input type="number" name="task_times[]" class="form-control" placeholder="Time required (hours)" value="<?php echo $task->time_required; ?>">
                </div>
            <?php endforeach; ?>
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
