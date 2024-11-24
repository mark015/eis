<?php
include('../incl/config.php'); // Include your database connection file
header('Content-Type: application/json');

// Fetch employees with 10, 15, 20, or 25 years of service
$sql = "
    SELECT id
    FROM `employee`
    WHERE 
        TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) IN (10, 15, 20, 25) 
        AND DATE_FORMAT(`date_original_app`, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d') and remarks !='read';
";

$result = $conn->query($sql);

// Initialize the notifications array
$notifications = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];

        // Update remarks to 'unread'
        $updateSql = "UPDATE `employee` SET `remarks` = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            $remarkText = 'unread';
            $stmt->bind_param('si', $remarkText, $id); // Bind parameters
            $stmt->execute();
            $stmt->close();
        }

        // Fetch updated data for employees with 'unread' remarks
        $sqlNotif = "
            SELECT id, `first_name`,
            TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) AS years_of_service
            FROM `employee`
            WHERE remarks = 'unread' AND id = ?
        ";
        $notifStmt = $conn->prepare($sqlNotif);

        if ($notifStmt) {
            $notifStmt->bind_param('i', $id); // Bind employee ID
            $notifStmt->execute();
            $notifResult = $notifStmt->get_result();

            if ($notifResult && $notifResult->num_rows > 0) {
                $rowNotif = $notifResult->fetch_assoc();

                // Add notification to the array
                $notifications[] = [
                    'name' => $rowNotif['first_name'],
                    'text' => $rowNotif['years_of_service'] . ' years of Service'
                ];
            }

            $notifStmt->close();
        }
    }
}

// If notifications array is empty, set the count to 0
if (empty($notifications)) {
    $response = [
        'success' => true,
        'data' => [
            'count' => 0,
            'messages' => []
        ]
    ];
} else {
    // Prepare the response with notifications
    $response = [
        'success' => true,
        'data' => [
            'count' => count($notifications),
            'messages' => $notifications
        ]
    ];
}

// Output the response as JSON
echo json_encode($response);

$conn->close();
?>
