<?php  
  
require_once __DIR__ . "/vendor/autoload.php";  

$mongoClient = new MongoDB\Client;

$collection = $mongoClient->hddatabase->projects;

$projects = $collection->find();

?>




