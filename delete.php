<?php
header('Content-Type: application/json; charset=utf-8'); // Set JSON Header

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

  // Database connection details
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'papreg5';

  // Establish a database connection
  $conn = new mysqli($host, $username, $password, $dbname);
  if ($conn->connect_error) {
    throw new Exception('Database connection failed: ' . $conn->connect_error);
  }

  $action = $_POST['action'];
  $formId = $_POST['formId'] ?? 0; // Retrieve formId, null by default

  switch ($action) {
    case 'deleteform':
      // Delete a single record where sid equals the provided formId
      $stmt = $conn->prepare("UPDATE main SET texts = '' WHERE sid = ?");
      if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
      }
      $stmt->bind_param('i', $formId);
      break;

    case 'deletetable1':
      // Delete multiple records based on a predefined array of sids
      $formIds = [3, 4, 5]; // Array of IDs to clear
      $placeholders = implode(',', array_fill(0, count($formIds), '?')); // Create placeholders for IN clause
      $stmt = $conn->prepare("UPDATE main SET texts = '' WHERE sid IN ($placeholders)");
      if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
      }
      $stmt->bind_param(str_repeat('i', count($formIds)), ...$formIds); // Bind array values
      break;

    default:
      throw new Exception('Invalid action');
  }

  // Execute the query
  if (!$stmt->execute()) {
    throw new Exception('Failed to execute query: ' . $stmt->error);
  }

  // Respond with success
  // echo json_encode(['status' => 'success']);
}
