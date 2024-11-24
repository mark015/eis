$(document).ready(function () {
    function updateBadgeAndMessages() {
        $.ajax({
            url: 'data/get_notifications.php', // Replace with your backend endpoint
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const { count, messages } = response.data;

                    // Update badge count
                    const badge = $('#messageBadge');
                    if (count > 0) {
                        badge.text(count).show(); // Update and show badge
                    } else {
                        badge.hide(); // Hide badge if count is 0
                    }

                    // Update dropdown messages
                    const messageList = $('#messageDropdown');
                    messageList.empty(); // Clear existing messages

                    if (messages.length > 0) {
                        messages.forEach(message => {
                            // Add the message to the dropdown list
                            messageList.prepend(`
                                <li class="nav-item">
                                    <a class="dropdown-item">
                                        <span>
                                            <span>${message.name}</span>
                                        </span>
                                        <span class="message">
                                            ${message.text}
                                        </span>
                                    </a>
                                </li>
                            `);
                        });
                    } else {
                        // Add "No new messages" if the list is empty
                        messageList.prepend('<li class="nav-item"><a class="dropdown-item">No new messages</a></li>');
                    }
                    messageList.append(`
                        <li class="nav-item">
                            <div class="text-center">
                                <button id="updateNotifBtn" class="dropdown-item">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                        </li>`);
                } else {
                    console.error('Failed to fetch notifications:', response.message);
                }
            },
            error: function () {
                console.error('An error occurred while fetching notifications.');
            }
        });
    }

    $(document).on('click', '#updateNotifBtn', function(){
        $.ajax({
            url: 'data/updateUnread.php', // Replace with your backend endpoint
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // Check if the response is successful
                if (response.success) {
                    // Redirect to a different page upon success
                    console.log('success')
                    window.location.href = 'index?link=years'; // Replace with the page you want to redirect to
                } else {
                    console.error('Failed to update the notifications.');
                }
            },
            error: function () {
                console.error('An error occurred while updating the notifications.');
            }
        });
    });

    function updateNotifEmpty(){
        $.ajax({
            url: 'data/updateNotif.php', // Replace with your backend endpoint
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // Check if the response is successful
                if (response.success) {
                    // Redirect to a different page upon success
                    console.log('success')
                    
                } else {
                    console.error('Failed to update the notifications.');
                }
            },
            error: function () {
                console.error('An error occurred while updating the notifications.');
            }
        });
    }
    setInterval(updateBadgeAndMessages, 86400000); // 24 hours in milliseconds
    setInterval(updateNotifEmpty, 86400000); // 24 hours in milliseconds
    // Initial call
    updateBadgeAndMessages();
});
