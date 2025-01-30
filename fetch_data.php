<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "papreg5";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(['response' => 'Database connection failed.']);
  exit();
}
$action = $_GET['action'] ?? null;

if (isset($_GET['formId']) && is_numeric($_GET['formId'])) {
  $formId = (int) $_GET['formId']; // แปลงเป็นจำนวนเต็มเพื่อความปลอดภัย


  if ($stmt = $conn->prepare("SELECT texts FROM main WHERE sid = ?")) {
    $stmt->bind_param("i", $formId); // ผูก formId กับคำสั่ง SQL
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
      $data = [];

      while ($row = $result->fetch_assoc()) {
        $data[] = [
          'sid' => $formId,
          'texts' => $row['texts']
        ];
      }
      // ส่งข้อมูลกลับในรูปแบบ JSON
      http_response_code(200);
      echo json_encode(['response' => 'success', 'data' => $data]);
    } else {
      // ไม่พบข้อมูลในฐานข้อมูล
      http_response_code(404);
      echo json_encode(['response' => 'no data found']);
    }

    $stmt->close();
  } else {
    // กรณีที่การเตรียมคำสั่ง SQL ล้มเหลว
    http_response_code(500);
    echo json_encode(['response' => 'error', 'message' => 'Database query failed.']);
  }

  $conn->close();
  exit;
}
