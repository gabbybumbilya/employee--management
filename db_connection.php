<?php
$host = 'sql207.infinityfree.com';
$dbname = 'if0_40216671_employee_management';
$username = 'if0_40216671';
$password = 'fkyyqGcV80YTYAs';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>