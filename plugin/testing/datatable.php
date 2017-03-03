<html>
    <head>
        <script src="//code.jquery.com/jquery-1.12.4.js" ></script>
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" ></script>



        <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">

        <script>
            $(document).ready(function() {
                $('#example').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax": "processing.php"
                } );
            } );
        </script>
    </head>
    <body>
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
            </tfoot>
        </table>
    </body>
</html>