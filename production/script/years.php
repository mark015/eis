<script>
    $(document).ready(function () {
    // Function to load employees based on search query and pagination
    function loadEmployees(page = 1, searchQuery = '') {
        $.ajax({
            url: 'data/numberService.php', // Backend endpoint
            type: 'GET',
            dataType: 'json',
            data: {
                page: page,
                searchQuery: searchQuery
            },
            success: function (response) {
                if (response.success) {
                    const { employees, totalPages, currentPage } = response.data;

                    // Update the employee table
                    const employeeTable = $('#employeeTable tbody');
                    employeeTable.empty(); // Clear existing rows
                    employees.forEach(employee => {
                        employeeTable.append(`
                            <tr>
                                <td>${employee.name}</td>
                                <td>${employee.years_of_service}</td>
                            </tr>
                        `);
                    });

                    // Update pagination buttons
                    $('#prevPage').prop('disabled', currentPage === 1);
                    $('#nextPage').prop('disabled', currentPage === totalPages);
                    $('#pageNumbers').text(`Page ${currentPage} of ${totalPages}`);
                }
            },
            error: function () {
                console.error('An error occurred while loading the employee data.');
            }
        });
    }

    // Initial load
    loadEmployees();

    // Handle search input change
    $('#searchLastName').on('input', function () {
        const searchQuery = $(this).val();
        loadEmployees(1, searchQuery); // Load first page with new search query
    });

    // Handle pagination buttons
    $('#prevPage').on('click', function () {
        const currentPage = parseInt($('#pageNumbers').text().split(' ')[1]);
        if (currentPage > 1) {
            loadEmployees(currentPage - 1, $('#searchLastName').val());
        }
    });

    $('#nextPage').on('click', function () {
        const currentPage = parseInt($('#pageNumbers').text().split(' ')[1]);
        const totalPages = parseInt($('#pageNumbers').text().split(' ')[3]);
        if (currentPage < totalPages) {
            loadEmployees(currentPage + 1, $('#searchLastName').val());
        }
    });
});
</script>
