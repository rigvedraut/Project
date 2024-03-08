<?php

session_start();

require 'config.php';

if (isset($_GET['id'])) {
    $projectId = $_GET['id'];
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
    if ($result->getDeletedCount() > 0) {
        $_SESSION['success'] = "Deletion of Project is successful";
    } else {
        $_SESSION['error'] = "Failed to delete project";
    }
    header("Location: index.php");
    exit;
} else {
    $_SESSION['error'] = "Project ID not provided";
    header("Location: index.php");
    exit;
}
?>
