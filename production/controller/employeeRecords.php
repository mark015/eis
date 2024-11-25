

<div class="container mt-4">
<h1>Employee Records</h1>
    <!-- Search Section -->
    <div class="row mb-3 search-container">
        <label for="searchLastName" class="form-label">Search by Last Name:</label>
        <input type="text" id="searchLastName" class="form-control" placeholder="Enter last name">
        <button type="button" class="justify-content-end btn btn-primary" id="addEmployee" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <!-- Employee Table -->
    <table id="employeeTable" class="table table-striped">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Employee Number</th>
                <th>Plantilla Item Number</th>
                <th>Date Original Appointment</th>
                <th>Position</th>
                <th>Employment Status</th>
                <th>Number of Service</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic rows will be injected here -->
        </tbody>
    </table>

<!-- Pagination Section -->
<div id="pagination" class="d-flex  justify-content-end mt-3">
    <button id="prevPage" class="btn btn-primary pagination-btn" disabled>Previous</button>
    <span id="pageNumbers" class="mx-3"></span>
    <button id="nextPage" class="btn btn-primary pagination-btn" disabled>Next</button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                
            </div>
            <form id="addEmployeeForm" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- id -->
                        <div class="col-md-6"hidden >
                            <label for="id" class="form-label required" >ID</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Enter Employee ID">
                        </div>
                        <!-- Employee Number -->
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label required">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Enter Employee ID" required>
                        </div>
                        <!-- Plantilla Item Number -->
                        <div class="col-md-6">
                            <label for="plantilla_item_number" class="form-label required">Plantilla Item Number</label>
                            <input type="text" class="form form-control" id="plantilla_item_number" name="plantilla_item_number" placeholder="Enter Plantilla Item Number" required>
                        </div>
                        <!-- First Name -->
                        <div class="col-md-3">
                            <label for="first_name" class="form-label required">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                        </div>
                        <!-- Middle Name -->
                        <div class="col-md-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name">
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-3">
                            <label for="last_name" class="form-label required">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                        </div>
                        <!-- Extension Name -->
                        <div class="col-md-3">
                            <label for="ext_name" class="form-label">Extension Name</label>
                            <input type="text" class="form-control" id="ext_name" name="ext_name" placeholder="e.g., Jr., Sr.">
                        </div>

                        <!-- Original date of Appointment -->
                        <div class="col-md-3">
                            <label for="date_appoint" class="form-label">Date of Appointment</label>
                            <input type="date" class="form-control" id="date_appoint" name="date_appoint">
                        </div>
                        <!-- Position -->
                        <div class="col-md-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" placeholder="Enter Position">
                        </div>
                        
                        <!-- Employment Status -->
                        <div class="col-md-3">
                            <label for="employment_status_id" class="form-label required">Employment Status</label>
                            <select class="form-select form-control" id="employment_status_id" name="employment_status_id" required>
                                <option selected disabled>Choose Employment Status</option>
                                <?php
                                    $sql = "SELECT id, status FROM emp_status";
                                    $result = $conn->query($sql);
                                
                                    if ($result->num_rows > 0) {
                                        // Output each row as an <option>
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['status'] . "</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No Employment Statuses Found</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- GSIS -->
                        <div class="col-md-3">
                            <label for="gsis" class="form-label">GSIS</label>
                            <input type="text" class="form-control" id="gsis" name="gsis" placeholder="Enter GSIS Number">
                        </div>
                        <!-- PhilHealth -->
                        <div class="col-md-4">
                            <label for="philhealth" class="form-label">PhilHealth</label>
                            <input type="text" class="form-control" id="philhealth" name="philhealth" placeholder="Enter PhilHealth Number">
                        </div>
                        <!-- Pag-IBIG -->
                        <div class="col-md-4">
                            <label for="pagibig" class="form-label">Pag-IBIG</label>
                            <input type="text" class="form-control" id="pagibig" name="pagibig" placeholder="Enter Pag-IBIG Number">
                        </div>
                        <!-- Status -->
                        <div class="col-md-4">
                            <label for="status" class="form-label required">Status</label>
                            <select class="form-select form-control" id="status" name="status" required>
                                <option selected disabled>Choose Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer" id="modalFooter">
                    
                </div>
            </form>
        </div>
    </div>
</div>