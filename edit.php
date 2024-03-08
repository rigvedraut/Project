<?php  
session_start();  
require 'config.php';  

if (isset($_GET['id'])) {  
    $projectId = $_GET['id'];
    $project = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
    $tasks = is_array($project->tasks) ? $project->tasks : [];
} else {
    echo "Project ID not provided.";
    exit();
}

if(isset($_POST['submit'])) {
    $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($projectId)],
        ['$set' => ['name' => $_POST['name']]]
    );

    $newTasks = explode("\n", $_POST['tasks']); 
    $newTasks = array_filter($newTasks, 'strlen');
    $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($projectId)],
        ['$set' => ['tasks' => $newTasks]]
    );

    $_SESSION['success'] = "Updating of Project is successful";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>  
<html>  
<head>  
    <title>CRUD Operation using MongoDB and PHP</title>  
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">  
    <link href="edit.css" rel="stylesheet">

</head>  
<body>  

<div class="container">  
    <h1>Edit Project</h1>  
    <a href="index.php" class="btn btn-primary">Back</a>  

    <form method="POST">  
        <div class="form-group">  
            <strong>Code:</strong>  
            <input type="text" name="code" value="<?php echo $project->code; ?>" required="" class="form-control" placeholder="Project Code" readonly>  
        </div> 
        <div class="form-group">  
            <strong>Name:</strong>  
            <input type="text" name="name" value="<?php echo $project->name; ?>" required="" class="form-control" placeholder="Project Name">  
        </div>  
        <div class="form-group">  
            <strong>Tasks:</strong>  
            <textarea class="form-control" name="tasks" placeholder="Project Tasks" placeholder="Project Tasks"><?php echo implode("\n", $tasks); ?></textarea>  
        </div>  
        <div class="form-group">  
            <button type="submit" name="submit" class="btn btn-success">Submit</button>  
        </div>  
    </form>  
</div>  

</body>  
</html>
