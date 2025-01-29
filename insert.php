<?php
$servername = "localhost";
$username = "root"; // Change this to your DB username
$password = ""; // Change this to your DB password
$dbname = "papreg5";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

  echo json_encode(['response' => 'Database connection failed: ' . $conn->connect_error]);
  exit();
}

$action = $_GET['action'] ?? null;
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
  }
}
$conn->close();
