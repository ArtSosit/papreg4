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

    case 'topic8':
      $id = $_POST['id'];
      // $placeholders = implode(',', array_fill(0, count($formIds), '?')); // สร้าง placeholders สำหรับ IN clause

      $stmt = $conn->prepare("DELETE FROM topic8 WHERE id = ?");
      if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error); // ถ้าเตรียมคำสั่งไม่ได้ ให้โยนข้อผิดพลาด
      }
      $stmt->bind_param('i', $id);
      $stmt->execute();
      if ($stmt->affected_rows > 0) {
        echo "ลบข้อมูลสำเร็จ";
      } else {
        echo "ไม่พบข้อมูลที่ต้องการลบ";
      }
      $stmt->close();
      break;

    case 'deletetable9_3':
      $id = $_POST['id'];
      // $placeholders = implode(',', array_fill(0, count($formIds), '?')); // สร้าง placeholders สำหรับ IN clause

      $stmt = $conn->prepare("DELETE FROM table9_3 WHERE id = ?");
      if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error); // ถ้าเตรียมคำสั่งไม่ได้ ให้โยนข้อผิดพลาด
      }
      $stmt->bind_param('i', $id);
      $stmt->execute();
      if ($stmt->affected_rows > 0) {
        echo "ลบข้อมูลสำเร็จ";
      } else {
        echo "ไม่พบข้อมูลที่ต้องการลบ";
      }
      $stmt->close();
      break;

    default:
      throw new Exception('Invalid action');
  }

  // Execute the query
  if (!$stmt->execute()) {
    throw new Exception('Failed to execute query: ' . $stmt->error);
  }
}
