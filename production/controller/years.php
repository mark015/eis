

<div class="container mt-4">
    <h1>Employee Records</h1>
    <!-- Search Section -->
    <div class="row mb-3 search-container">
        <label for="searchLastName" class="form-label">Search by Last Name:</label>
        <input type="text" id="searchLastName" class="form-control" placeholder="Enter last name">  
    </div>
    <!-- Employee Table -->
    <table id="employeeTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Service of Years</th>
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