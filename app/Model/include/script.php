<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
<script src="http://localhost/projectlibment/app/Model/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<!-- Bootstrap datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<!-- Bootstrap datepicker JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: '1d',
        datesDisabled: '+2d',
        keyboardNavigation: false,
        autoclose: true,
        timezone: 'UTC+07:00'
    });
    $(document).ready(function() {
        $('#datepicker').datepicker();
    });
</script>

<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable({
            responsive: true,
            autoWidth: true,
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#datatablesSimple').addClass("table table-hover table-bordered cell-border ");
    });
</script>

<script>
    function validateFile(event) {
        // Get the file input element
        var input = document.getElementById('image-upload');

        // Check if the selected file is an image
        if (!input.files[0].type.startsWith('image/')) {
            alert('Please select an image file!!!');
            event.preventDefault();
            return false;
        }

        // Check if the selected file size is within the allowed limit (5MB)
        const file = input.files[0];
        const fileSizeInBytes = file.size; // Get file size in bytes
        const maxSizeInBytes = 5 * 1024 * 1024; // 5MB in bytes

        if (fileSizeInBytes > maxSizeInBytes) {
            alert('Image size is too large. Size cannot be more than 5MB, Please choose a smaller image!!!');
            event.preventDefault();
            return false;
        }

        return true;
    }
</script>