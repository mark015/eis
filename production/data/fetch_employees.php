<?php
include ('../incl/config.php');
header('Content-Type: application/json');
try {
    // Get the filter and pagination parameters
    $lastName = isset($_GET['last_name']) ? $_GET['last_name'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $recordsPerPage = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 5;

    // Calculate offset for pagination
    $offset = ($page - 1) * $recordsPerPage;

    // Base query
    $query = "SELECT employee.id as eid,
                plantilla_item_number, date_original_app, first_name, 
                middle_name, last_name, ext_name, empoyee_number, position,
                emp_status.status AS employment_status, gsis, philhealth, 
                pagibig, employee.status AS employee_status,TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) as year_of_service
              FROM employee
              INNER JOIN emp_status ON employee.employment_status_id = emp_status.id";

    // Add filter condition if a last name is provided
    if (!empty($lastName)) {
        $query .= " WHERE last_name LIKE ?";
    }

    // Add LIMIT and OFFSET for pagination
    $query .= " LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($query);

    // Bind the parameters for filter and pagination
    if (!empty($lastName)) {
        $likeLastName = "%$lastName%";
        $stmt->bind_param('sss', $likeLastName, $recordsPerPage, $offset);
    } else {
        $stmt->bind_param('ii', $recordsPerPage, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $employees = [];

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    // Get total number of pages
    $totalQuery = "SELECT COUNT(*) AS total FROM employee";
    if (!empty($lastName)) {
        $totalQuery .= " WHERE last_name LIKE ?";
    }

    $totalStmt = $conn->prepare($totalQuery);
    if (!empty($lastName)) {
        $totalStmt->bind_param('s', $likeLastName);
    }
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $totalRows = $totalResult->fetch_assoc()['total'];

    $totalPages = ceil($totalRows / $recordsPerPage);

    echo json_encode([
        'success' => true,
        'data' => $employees,
        'totalPages' => $totalPages
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching employee data: ' . $e->getMessage()
    ]);
}

$conn->close();
?>