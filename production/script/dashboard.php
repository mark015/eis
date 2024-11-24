<script>
$(document).ready(function() {
    // Function to fetch and update counts
    function fetchEmployeeCounts() {
        $.ajax({
            url: 'data/get_employee_count.php', // Your PHP file to get the data
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update the count values in the respective tiles
                    $('#count_10_years').text(response.data.count_10_years);
                    $('#count_15_to_20_years').text(response.data.count_15_to_20_years);
                    $('#count_20_to_25_years').text(response.data.count_20_to_25_years);
                    $('#count_25_years').text(response.data.count_25_years);
                } else {
                    console.error('Failed to fetch employee counts:', response.message);
                }
            },
            error: function() {
                console.error('An error occurred while fetching employee counts.');
            }
        });
    }

    // Call the function to fetch employee counts on page load
    fetchEmployeeCounts();
    
    // Optionally, you can set an interval to update the counts every 24 hours (86400000 ms)
    setInterval(fetchEmployeeCounts, 86400000); // 24 hours
});
</script>