<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

try {
  $conn = new mysqli("localhost", "root", "", "papreg5");

  if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
  }

  $action = $_GET['action'] ?? '';
  if ($action === 'table1') {
    $formIds = [3, 4, 5];

    if (!empty($formIds) && is_array($formIds)) {
      $placeholders = implode(',', array_fill(0, count($formIds), '?'));
      $query = "SELECT * FROM main WHERE sid IN ($placeholders)";
      $stmt = $conn->prepare($query);

      if (!$stmt) {
        die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param(str_repeat('i', count($formIds)), ...$formIds);
      $stmt->execute();

      if ($stmt->error) {
        die("Query failed: " . $stmt->error);
      }
      $result = $stmt->get_result();
      $data = $result->fetch_all(MYSQLI_ASSOC);

      echo json_encode(['response' => 'success', 'data' => $data]);
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'error', 'message' => 'Invalid form IDs']);
    }
  } elseif ($action === 'table9_3') {

    $query = "SELECT * FROM table9_3";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
      http_response_code(500);
      echo json_encode(['response' => 'error', 'message' => 'Database error: ' . $conn->error]);
      exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['response' => 'success', 'data' => $data]);
  } else {
    http_response_code(400);
    echo json_encode(['response' => 'error', 'message' => 'Invalid request']);
  }



  $conn->close();
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['response' => 'error', 'message' => $e->getMessage()]);
}
