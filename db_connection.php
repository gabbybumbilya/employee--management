<?php
$host = 'sql306.infinityfree.com'; // from InfinityFree cPanel (your MySQL hostname)
$dbname = 'if0_40208704_employee_management'; // your actual database name
$username = 'if0_40208704'; // your actual MySQL username
$password = 'EPQLAksC0AlZj'; // your actual MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
