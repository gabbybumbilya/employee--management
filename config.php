<?php
// Configuration and common functions
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header for API responses
function jsonHeader() {
    header('Content-Type: application/json');
}

// Send JSON response
function sendResponse($data, $success = true) {
    jsonHeader();
    echo json_encode([
        'success' => $success,
        'data' => $data
    ]);
    exit;
}

// Send error response
function sendError($message) {
    jsonHeader();
    echo json_encode([
        'success' => false,
        'error' => $message
    ]);
    exit;
}
?>