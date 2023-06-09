<?php
require_once 'dbconfig.php';

$query = "SELECT * FROM users";
$statement = $conn->prepare($query);
$statement->execute();

$results = $statement->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>
