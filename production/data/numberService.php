<?php
include('../incl/config.php'); // Include your database connection file
header('Content-Type: application/json');

// Get the current page and search query from the request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

// Set the number of records per page
$recordsPerPage = 10;

// Calculate the offset for pagination
$offset = ($page - 1) * $recordsPerPage;

// Create the SQL query
$sql = "
    SELECT id, CONCAT(first_name, ' ', last_name) AS name, 
           TIMESTAMPDIFF(YEAR, date_original_app, CURDATE()) AS years_of_service
    FROM employee
    WHERE last_name LIKE ? 
    LIMIT ?, ?
";

$stmt = $conn->prepare($sql);
$searchTerm = "%" . $searchQuery . "%"; // Search term for last name
$stmt->bind_param("sii", $searchTerm, $offset, $recordsPerPage);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all rows
$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

// Get total number of records for pagination
$sqlTotal = "SELECT COUNT(*) AS total FROM employee WHERE last_name LIKE ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param("s", $searchTerm);
$stmtTotal->execute();
$totalResult = $stmtTotal->get_result();
$totalRecords = $totalResult->fetch_assoc()['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Prepare the response
$response = [
    'success' => true,
    'data' => [
        'employees' => $employees,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'totalRecords' => $totalRecords
    ]
];

// Output the response as JSON
echo json_encode($response);

$stmt->close();
$stmtTotal->close();
$conn->close();
?>
