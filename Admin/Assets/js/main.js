$(document).ready(function(){
    $(".approveBtn").click(function() {
        let id = $(this).data("id");
        updateStatus(id, "approved");
    });

    $(".rejectBtn").click(function() {
        let id = $(this).data("id");
        updateStatus(id, "rejected");
    });

    function updateStatus(id, status) {
        $.ajax({
            url: "update_status.php",
            method: "POST",
            data: { id: id, status: status },
            success: function(response) {
                $("#status-" + id).text(status.charAt(0).toUpperCase() + status.slice(1));
            }
        });
    }
});