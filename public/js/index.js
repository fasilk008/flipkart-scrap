$(document).ready(function() {
    // data table initialization
    $('#tableData').DataTable({
        "order": [[ 2, "asc" ]]
    });
});

// scrap now button action
$("#scrap-now").click(function(){
    $("#scrap-now-load").removeClass("d-none");
    $(this).prop('disabled', true);
    window.location = "scrap";
});