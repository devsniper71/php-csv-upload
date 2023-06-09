<?php
session_start();
$summary = $_SESSION['summary'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Summary Report</title>
</head>
<body>
<a href="index.html">Go back to Homepage</a>

<h2>Summary Report</h2>
<table>
    <tr>
        <th>Stat</th>
        <th>Count</th>
    </tr>
    <?php foreach ($summary as $stat => $count): ?>
        <tr>
            <td><?= $stat; ?></td>
            <td><?= $count; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Search Data</h2>
<input type="text" id="searchInput" placeholder="Search...">
<table id="dataTable">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Gender</th>
        <th>Address</th>
    </tr>
    <!-- The data will be dynamically populated using AJAX -->
</table>

<script src="script.js"></script>
</body>
</html>
