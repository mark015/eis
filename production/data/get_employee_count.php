<?php
include('../incl/config.php'); // Include your database connection file
header('Content-Type: application/json');

// SQL query to count employees based on service years
$query = "
    SELECT 
    (SELECT COUNT(id) 
     FROM `employee` 
     WHERE TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) >= 10 
     AND TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) < 15) AS count_10_years,
    (SELECT COUNT(id) 
     FROM `employee` 
     WHERE TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) >= 15
     AND TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) < 20) AS count_15_to_20_years,
    (SELECT COUNT(id) 
     FROM `employee` 
     WHERE TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) >= 20
     AND TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) < 25) AS count_20_to_25_years,
    (SELECT COUNT(id) 
     FROM `employee` 
     WHERE TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) >= 25) AS count_25_years;

";

// Execute the query and fetch the result
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching data'
    ]);
}
?>
