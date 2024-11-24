<?php
include('../incl/config.php');
header('Content-Type: application/json');

$response = [];

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!empty($id)) {
        // SQL query to delete the item
        $sql = "DELETE FROM employee WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Item deleted successfully.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to delete item.'
            ];
        }
        $stmt->close();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid item ID.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
}

// Return the response as JSON
echo json_encode($response);
$conn->close();
?>
