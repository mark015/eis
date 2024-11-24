<script>
let currentPage = 1; // Start with the first page
const recordsPerPage = 3; // Number of records per page

// Function to fetch and display employee data with pagination
function fetchEmployees(lastName = '', page = 1) {
    $.ajax({
        url: 'data/fetch_employees.php',
        type: 'GET',
        dataType: 'json',
        data: {
            last_name: lastName,
            page: page,
            records_per_page: recordsPerPage
        },
        success: function (response) {
            if (response.success) {
                let rows = '';
                if (response.data.length > 0) {
                    response.data.forEach(function (employee) {
                        var role ="<?php echo $rowUser['role'];?>";
                        
                        rows += `<tr>
                            <td>${[
                                employee.first_name,
                                employee.middle_name,
                                employee.last_name,
                                employee.ext_name,
                            ]
                                .filter(Boolean)
                                .join(' ')}</td>
                            <td>${employee.empoyee_number || 'N/A'}</td>
                            <td>${employee.plantilla_item_number || 'N/A'}</td>
                            <td>${employee.date_original_app || 'N/A'}</td>
                            <td>${employee.employment_status || 'N/A'}</td>
                            <td>${employee.gsis || 'N/A'}</td>
                            <td>${employee.philhealth || 'N/A'}</td>
                            <td>${employee.pagibig || 'N/A'}</td>
                            <td>${employee.employee_status || 'N/A'}</td>
                            <td>
                                ${role !== 'User' 
                                ? `<button class="btn btn-danger" data-delete-id="${employee.eid}" id="deleteEmployee"><i class="fa fa-trash"></i></button>` 
                                : ''}
                                <button class="btn btn-secondary" data-update-id="${employee.eid}" id="updateEmployee"><i class="fa fa-pencil"></i></button>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="9">No records found</td></tr>';
                }

                $('#employeeTable tbody').html(rows);
                updatePagination(response.totalPages, page); // Update pagination controls
            } else {
                alert(response.message || 'Unable to fetch employee data.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error(xhr.responseText);

            alert('An error occurred while fetching employee data. Please try again later.');
        }
    });
}

// Update pagination controls
function updatePagination(totalPages, currentPage) {
    let pageNumbers = '';
    const maxPagesToShow = 3; // Number of pages to display at a time (1 2 3 ... 10)
    
    // Logic for calculating start and end pages for pagination
    let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
    let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

    // Adjust if there are fewer pages available
    if (endPage - startPage + 1 < maxPagesToShow) {
        startPage = Math.max(1, endPage - maxPagesToShow + 1);
    }

    // Add Previous and Next buttons with disabled states
    $('#prevPage').prop('disabled', currentPage === 1);
    $('#nextPage').prop('disabled', currentPage === totalPages);

    // Add "Previous" button and page numbers with ellipses if necessary
    if (startPage > 1) {
        pageNumbers += '<span class="ellipsis">...</span>';
    }

    // Add individual page numbers
    for (let i = startPage; i <= endPage; i++) {
        pageNumbers += `<button class="pagination-btn pageNumber" data-page="${i}">${i}</button>`;
    }

    if (endPage < totalPages) {
        pageNumbers += '<span class="ellipsis">...</span>';
    }

    // Insert the page numbers into the pagination container
    $('#pageNumbers').html(pageNumbers);
}

// Filter by Last Name and fetch employee data
$('#searchLastName').on('keyup', function () {
    const lastName = $(this).val().trim();
    currentPage = 1; // Reset to the first page when filtering
    fetchEmployees(lastName, currentPage);
});

// Pagination button click event
$(document).on('click', '.pageNumber', function () {
    currentPage = $(this).data('page');
    const lastName = $('#searchLastName').val().trim();
    fetchEmployees(lastName, currentPage);
});

// Previous page button click event
$('#prevPage').click(function () {
    if (currentPage > 1) {
        currentPage--;
        const lastName = $('#searchLastName').val().trim();
        fetchEmployees(lastName, currentPage);
    }
});

// Next page button click event
$('#nextPage').click(function () {
    const totalPages = $('#pageNumbers').children().length;
    if (currentPage < totalPages) {
        currentPage++;
        const lastName = $('#searchLastName').val().trim();
        fetchEmployees(lastName, currentPage);
    }
});

// Initialize pagination and employee data on page load
$(document).ready(function () {
    fetchEmployees(); // Initial fetch with default page and records per page
});

//Add Employee

$(document).on('click', '#addEmployee', function() {
    
    $('#addEmployeeForm')[0].reset(); 
    $('#modalHeader').html(`<h5 class="modal-title" id="modalTitle">Add Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`);
    $('#modalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i> Save Employee</button>`);
    
})
function addEmployee(){
    $(document).ready(function () {
        $("#addEmployeeForm").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
                url: "data/addEmployee.php",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Employee Added!',
                            text: response.message, // Display message from server
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reset the form and hide the modal
                                $('#addEmployeeForm')[0].reset(); 
                                $('#addModal').modal('hide'); // Close the modal
                                fetchEmployees(); // Refresh employee list
                            }
                        });
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                }
            });
        });
    });
}

//update Employee 
$(document).on('click', '#updateEmployee', function() {
    const id = $(this).data('update-id'); // Get the selected employee's ID
    $('#addEmployeeForm')[0].reset(); 
    $('#addModal').modal('show'); // show the modal
    $('#modalHeader').html(`<h5 class="modal-title" id="modalTitle">Update Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`);
    $('#modalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="updateEmp" class="btn btn-primary"><i class="fa fa-save me-2"></i> Update Employee</button>`);
    $.ajax({
        url: 'data/get_employee.php', // PHP script to fetch employee data
        type: 'GET',
        dataType: 'json',
        data: { employee_id: id },
        success: function(response) {
            if (response.success) {
                const employee = response.data;
                // Fill the form with existing employee data
                $('#employee_id').val(employee.empoyee_number);
                $('#id').val(employee.id);
                $('#plantilla_item_number').val(employee.plantilla_item_number);
                $('#first_name').val(employee.first_name);
                $('#middle_name').val(employee.middle_name);
                $('#last_name').val(employee.last_name);
                $('#ext_name').val(employee.ext_name);
                $('#date_appoint').val(employee.date_original_app);
                $('#employment_status_id').val(employee.employment_status_id);
                $('#gsis').val(employee.gsis);
                $('#philhealth').val(employee.philhealth);
                $('#pagibig').val(employee.pagibig);
                $('#status').val(employee.status);

                // Show the modal
                $('#updateModal').modal('show');
            } else {
                alert('Failed to fetch employee data.');
            }
        }
    });
});
$(document).on('click', '#updateEmp' , function(){
    var  id =$('#id').val();
    var  employee_id = $('#employee_id').val();
    var  plantilla_item_number =$('#plantilla_item_number').val();
    var  first_name =$('#first_name').val();
    var  middle_name =$('#middle_name').val();
    var  last_name =$('#last_name').val();
    var  ext_name =$('#ext_name').val();
    var  date_appoint =$('#date_appoint').val();
    var  employment_status_id =$('#employment_status_id').val();
    var  gsis =$('#gsis').val();
    var  philhealth =$('#philhealth').val();
    var  pagibig =$('#pagibig').val();
    var  status = $('#status').val();
    
    $.ajax({
        url: 'data/update_employee.php', // PHP script to fetch employee data
        type: 'POST',
        dataType: 'json',
        data: { 
            id: id,
            employee_id: employee_id,
            plantilla_item_number: plantilla_item_number,
            middle_name: middle_name,
            last_name: last_name,
            ext_name: ext_name,
            date_appoint: date_appoint,
            employment_status_id: employment_status_id,
            gsis: gsis,
            philhealth: philhealth,
            pagibig: pagibig,
            status: status,
            first_name: first_name,

         },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Employee Updated!',
                text: response.message, // Display message from server
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reset the form and hide the modal
                    $('#addEmployeeForm')[0].reset(); 
                    $('#addModal').modal('hide'); // Close the modal
                    fetchEmployees(); // Refresh employee list
                }
            });
        }
    });

})


function deleteEmployee(){
    $(document).on('click', '#deleteEmployee', function() {
        const id = $(this).data('delete-id'); // Get the item ID from data-id

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, send AJAX request to delete the item
                $.ajax({
                    url: 'data/delete_employee.php', // Replace with your delete script URL
                    type: 'POST', // HTTP method
                    data: { id: id }, // Send the item ID to the server
                    success: function(response) {
                        if (response.status === 'success') {

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message, // Display message from server
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    fetchEmployees(); // Refresh employee list
                                }
                            });
                            // Optionally remove the item from the DOM or reload the page
                           
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while processing your request.',
                            'error'
                        );
                    }
                });
            }
        });
    });

}


// Initialize Functions
$(document).ready(function () {
    fetchEmployees(); // Fetch employees initially when the page loads
    addEmployee(); // Attach event handler for the form submission
    deleteEmployee(); 
});

</script>