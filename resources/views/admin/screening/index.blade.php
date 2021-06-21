@extends('layouts.adminapp')
@push('assets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush


@section('content')
    <div class="container">
        <div class="row ml-1 mb-3">
            <a href="/admin" style="float:left">
                <button class="btn btn-primary">< Back to Dashboard</button>
            </a>
        </div>
        <h1 style="color:black; float:left">Screening List</h1>
        <a href="screening/create" style="float:right">
            <button class="btn btn-info">New Screening</button>
        </a>
        <table id="screeningTable" class="table table-bordered data-table">
            <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>

                {{-- <th>Movie Id</th> --}}
                <th>Movie Title</th>
                {{-- <th>Poster path</th> --}}
                <th>Duration</th>
                {{-- <th>Age</th> --}}
                {{-- <th>Categories</th> --}}
                {{-- <th>Auditorium Id</th> --}}
                <th>Auditorium Name</th>
                <th>Seats number</th>

                <th width="100px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <hr>

    {{-- ticket bellow --}}
    <div class="container mt-5">
        <h1 style="color:black; float:left">Ticket Reservations</h1>
        <a href="{{route('tickets.create')}}" style="float:right">
            <button class="btn btn-info">Add Ticket Reservation</button>
        </a>
        <table id="ticketTable" class="table table-bordered data-table">
            <thead>
            <tr>
                <th width="30px">No</th>
                <th width="100px">Screening ID</th>
                <th>Seat</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th width="100px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" defer>
        console.log('help');
        $(function () {
            var table = $('#screeningTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('screening.index')}}",
                columns: [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {data: 'sId', name: 'sId'},
                    {data: 'sDate', name: 'sDate'},
                    {data: 'sTime', name: 'sTime'},

                    //   {data: 'mId', name: 'mId'},
                    {data: 'title', name: 'title'},
                    //   {data: 'posterpath', name: 'posterpath'},
                    {data: 'duration', name: 'duration'},
                    //   {data: 'age', name: 'age'},
                    //   {data: 'categories', name: 'categories'},

                    //   {data: 'aId', name: 'aId'},
                    {data: 'aName', name: 'aName'},
                    {data: 'seats', name: 'seats'},

                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "order": [[1, "asc"]]

            });
            var ticket = $('#ticketTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('tickets.index')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
                    {data: 'screeningId', name: 'screeningId'},
                    {data: 'seat', name: 'seat'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "order": [[1, "asc"]]
            });

            $('#screeningTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            function format(d) {
                console.log(d);
                // `d` is the original data object for the row
                return '<table class="table">' +
                    '<tr class="table-secondary">' +
                    '<td style="width:30%">Movie ID - Title:</td>' +
                    '<td style="width:69%">' + d.mId + ' - ' + d.title + '</td>' +
                    '</tr>' +
                    '<tr class="table-secondary">' +
                    '<td>Thumbnail :</td>' +
                    '<td> <img src="/' + d.posterpath + '" style="width:50px;height:50px;"> </td>' +
                    '</tr>' +
                    '<tr class="table-secondary">' +
                    '<td>[Age Rating] and Cateogories:</td>' +
                    '<td>PG-[' + d.age + '], ' + d.categories + '</td>' +
                    '</tr>' +
                    '<tr class="table-secondary">' +
                    '<td>Auditorium ID - Name: </td>' +
                    '<td>' + d.aId + ' - ' + d.aName + '</td>' +
                    '</tr>' +
                    '<tr class="table-secondary">' +
                    '<td>Auditorium booked seat(s): </td>' +
                    '<td>' + (d.booked == null ? 0 : d.booked.count) + '</td>' +
                    '</tr>' +
                    '<tr class="table-secondary">' +
                    '<td>Available seat(s): </td>' +
                    '<td>' + (d.seats - (d.booked == null ? 0 : d.booked.count)) + '/' + d.seats + '</td>' +
                    '</tr>' +
                    '</table>'
            }
        });
    </script>
@endpush

