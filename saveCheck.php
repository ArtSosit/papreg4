<?php
// ตรวจสอบว่ามีค่าที่ส่งมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // รับค่าจาก AJAX
  $col1 = isset($_POST['col1']) ? $_POST['col1'] : 0;
  $col2 = isset($_POST['col2']) ? $_POST['col2'] : 0;
  $col3 = isset($_POST['col3']) ? $_POST['col3'] : 0;
  $col4 = isset($_POST['col4']) ? $_POST['col4'] : 0;
  $col5 = isset($_POST['col5']) ? $_POST['col5'] : 0;
  $col6 = isset($_POST['col6']) ? $_POST['col6'] : 0;
  $col7 = isset($_POST['col7']) ? $_POST['col7'] : 0;
  $col8 = isset($_POST['col8']) ? $_POST['col8'] : 0;
  $col9 = isset($_POST['col9']) ? $_POST['col9'] : 0;
  $col10 = isset($_POST['col10']) ? $_POST['col10'] : 0;
  $col11 = isset($_POST['col11']) ? $_POST['col11'] : 0;
  $col12 = isset($_POST['col12']) ? $_POST['col12'] : 0;
  $col13 = isset($_POST['col13']) ? $_POST['col13'] : 0;

  // เชื่อมต่อฐานข้อมูล
  $conn = new mysqli("localhost", "root", "", "papreg5");

  // ตรวจสอบการเชื่อมต่อ
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // สมมุติว่าใช้ id ในการอัปเดตข้อมูล
  $id = 1; // ตัวอย่าง ID ที่ต้องการอัปเดต

  // SQL อัปเดตค่า
  $sql = "INSERT INTO 7checkbox (cid,col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, col11, col12, col13) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
          ON DUPLICATE KEY UPDATE 
            col1 = VALUES(col1), col2 = VALUES(col2), col3 = VALUES(col3), col4 = VALUES(col4), col5 = VALUES(col5), col6 = VALUES(col6), col7 = VALUES(col7), col8 = VALUES(col8), col9 = VALUES(col9), col10 = VALUES(col10), col11 = VALUES(col11), col12 = VALUES(col12), col13 = VALUES(col13)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iiiiiiiiiiiiii", $id, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13);

  if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลเรียบร้อย!"]);
  } else {
    echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการบันทึกข้อมูล"]);
  }

  // ปิดการเชื่อมต่อ
  $stmt->close();
  $conn->close();
}
