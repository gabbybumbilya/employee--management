<?php
$host = 'sql207.infinityfree.com';
$dbname = 'if0_40216671_employee_management';
$username = 'if0_40216671';
$password = 'fkyyqGcV80YTYAs';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>