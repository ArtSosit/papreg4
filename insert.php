<?php
$servername = "localhost";
$username = "root"; // Change this to your DB username
$password = ""; // Change this to your DB password
$dbname = "papreg5";
header('Content-Type: application/json');
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

  echo json_encode(['response' => 'Database connection failed: ' . $conn->connect_error]);
  exit();
}

$action = $_POST['action'] ?? null;
// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the action from POST data
  $action = isset($_POST['action']) ? $_POST['action'] : null;

  if ($action === 'saveform') {
    // Retrieve and decode the Base64 reason
    $data = $_POST['data'] ?? null;
    $formId = $_POST['formId'] ?? null;

    if ($data && $formId) {
      // $data = urldecode(base64_decode($encodeddata));

      // Use INSERT ... ON DUPLICATE KEY UPDATE
      $stmt = $conn->prepare("
        INSERT INTO main (sid, texts) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE 
        texts = VALUES(texts)
      ");
      $stmt->bind_param("is", $formId, $data);

      if ($stmt->execute()) {
        echo json_encode(['response' => 'Data saved successfully!']);
      } else {
        http_response_code(500);
        echo json_encode(['response' => 'Failed to save data: ' . $stmt->error]);
      }

      $stmt->close();
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'Invalid input data.']);
    }
  } elseif ($action === 'Allsave') {
    // Retrieve POST data with default values
    $origin_info = $_POST['origin_Info'] ?? ''; // Match case consistently  
    $new_info = $_POST['new_info'] ?? '';
    $Closing_content = $_POST['Closing_content'] ?? '';

    // Validate inputs to ensure all fields are provided
    if (empty($origin_info) || empty($new_info) || empty($Closing_content)) {
      http_response_code(400);
      echo json_encode(['response' => 'Invalid input: All fields are required.']);
      exit;
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("
        INSERT INTO main (sid, texts) 
        VALUES (3, ?), (4, ?), (5, ?)
        ON DUPLICATE KEY UPDATE 
            texts = VALUES(texts)
    ");

    // Check for SQL preparation errors
    if ($stmt === false) {
      http_response_code(500);
      echo json_encode(['response' => 'Failed to prepare statement: ' . $conn->error]);
      exit;
    }

    // Bind parameters to the SQL statement
    $stmt->bind_param("sss", $origin_info, $new_info, $Closing_content);

    // Execute the statement and handle the result
    if ($stmt->execute()) {
      echo json_encode(['response' => 'Data saved successfully!']);
    } else {
      http_response_code(500);
      echo json_encode(['response' => 'Failed to save data: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
  } elseif ($action === 'saveTopic8') {

    // ดึงค่าจาก JSON แทนที่จะดึงจาก $_POST โดยตรง
    $id = $_POST['id'] ?? null;
    $type = $_POST['type'] ?? "";
    $people = $_POST['people'] ?? 0;
    $year1 = $_POST['year1'] ?? 0;
    $year2 = $_POST['year2'] ?? 0;
    $year3 = $_POST['year3'] ?? 0;
    $year4 = $_POST['year4'] ?? 0;
    $year5 = $_POST['year5'] ?? 0;

    // SQL Query to insert the admissions data (id = 1) with ON DUPLICATE KEY UPDATE
    if ($id) {
      $sql = "INSERT INTO topic8 (id,type,admission_plan, year1, year2, year3, year4, year5) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE 
          type = VALUES(type), 
          admission_plan=VALUES(admission_plan),
          year1 = VALUES(year1), 
          year2 = VALUES(year2), 
          year3 = VALUES(year3), 
          year4 = VALUES(year4), 
          year5 = VALUES(year5)";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("isiiiiii", $id, $type, $people, $year1, $year2, $year3, $year4, $year5);
    } else {
      $sql = "INSERT INTO topic8 (type, admission_plan, year1, year2, year3, year4, year5) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("siiiiii", $type, $people, $year1, $year2, $year3, $year4, $year5);
    }

    if ($stmt->execute()) {
      // Get the last inserted id
      $last_inserted_id = $conn->insert_id;

      // Send a response back to the client including the id
      echo json_encode([
        'response' => 'Data saved successfully!',
        'id' => $last_inserted_id
      ]);
    } else {
      // Handle any errors that occur during insertion
      echo json_encode(['response' => 'Error saving data']);
    }
  } else {
    http_response_code(500);
    echo json_encode(['response' => 'Failed to save data: ' . $stmt->error]);
  }
}

$conn->close();
