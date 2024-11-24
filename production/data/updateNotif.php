<?php
include('../incl/config.php'); // Include your database connection file
header('Content-Type: application/json');

// Update query to set `remarks` to 'unread' where `remarks` is 'read'
$updateSql = "UPDATE `employee` SET `remarks` = ? WHERE remarks = ?";
$stmt = $conn->prepare($updateSql);

if ($stmt) {
    $remarkText = '';
    $remarks = 'read';
    
    $stmt->bind_param('ss', $remarkText, $remarks); // Bind parameters
    $stmt->execute(); // Execute the query
    $stmt->close(); // Close the statement

    // Return a success message in JSON format
    echo json_encode(['success' => true]);
} else {
    // Handle failure to prepare the statement
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
}
?>
