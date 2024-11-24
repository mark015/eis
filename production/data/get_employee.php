<?php

include ('../incl/config.php');
header('Content-Type: application/json');

if (isset($_GET['employee_id'])) {
    $employeeId = $_GET['employee_id'];

    // Example SQL query
    $sql = "SELECT * FROM employee WHERE id = '$employeeId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $employee]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Employee not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid employee ID']);
}
?>
