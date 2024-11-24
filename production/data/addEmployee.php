<?php
include ('../incl/config.php');
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and assign form data// Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time
    $employee_id = $_POST['employee_id'];
    $plantilla_item_number = $_POST['plantilla_item_number'];
    $first_name = $_POST['first_name'];
    $date_appoint = $_POST['date_appoint'] ?? null;
    $middle_name = $_POST['middle_name'] ?? null;
    $last_name = $_POST['last_name'];
    $ext_name = $_POST['ext_name'] ?? null;
    $employment_status_id = $_POST['employment_status_id'];
    $gsis = $_POST['gsis'] ?? null;
    $philhealth = $_POST['philhealth'] ?? null;
    $pagibig = $_POST['pagibig'] ?? null;
    $status = $_POST['status'];

    // SQL query to insert data
    $sql = "INSERT INTO employee 
            (plantilla_item_number, date_original_app, first_name, middle_name, last_name, ext_name, empoyee_number, employment_status_id, gsis, philhealth, pagibig, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('ssssssssssss', 
            $plantilla_item_number, 
            $date_appoint, 
            $first_name, 
            $middle_name, 
            $last_name, 
            $ext_name, 
            $employee_id, 
            $employment_status_id, 
            $gsis, 
            $philhealth, 
            $pagibig, 
            $status
        );

        // Execute and return success or error
        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Employee added successfully.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error adding employee: ' . $stmt->error
            ];
        }

        $stmt->close();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Database query error: ' . $conn->error
        ];
    }

    $conn->close();
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
}

// Return response as JSON
echo json_encode($response);
?>