<?php
    // Get employee ID from the URL
    $employeeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Prepare the query to fetch employee data
    $sql = "SELECT employee.id as eid,
                plantilla_item_number, date_original_app, first_name, 
                middle_name, last_name, ext_name, empoyee_number, position,
                emp_status.status AS employment_status, gsis, philhealth, 
                pagibig, employee.status AS employee_status,TIMESTAMPDIFF(YEAR, `date_original_app`, CURDATE()) as year_of_service
              FROM employee
              INNER JOIN emp_status ON employee.employment_status_id = emp_status.id where employee.id=?";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeId);  // Bind the employee ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any employee data is returned
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc(); // Fetch employee data
    } else {
        echo "Employee not found.";
        exit;
    }

    // Close the statement and connection
    $stmt->close();
?>
<div class="container mt-4 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg" style="width: 400px; border-radius: 15px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Employee</h3>
            <table class="table table-borderless">
                <tr>
                    <td class="fw-bold text-secondary">Name:</td>
                    <td class="text-dark"><?php echo ucwords($employee['first_name'] . ' ' . $employee['middle_name'] . ' ' . $employee['last_name']. ' ' . $employee['ext_name']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Employee Number:</td>
                    <td class="text-dark"><?php echo $employee['empoyee_number']; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Position:</td>
                    <td class="text-dark"><?php echo $employee['position']; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Employment Status:</td>
                    <td class="text-dark"><?php echo $employee['employment_status']; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Years of Service:</td>
                    <td class="text-dark"><?php echo $employee['year_of_service']; ?> years</td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">GSIS:</td>
                    <td class="text-dark"><?php echo $employee['gsis']; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Philhealth:</td>
                    <td class="text-dark"><?php echo $employee['philhealth']; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold text-secondary">Pagibig:</td>
                    <td class="text-dark"><?php echo $employee['pagibig']; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
