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
        <h1 style="color:black; float:left">Movie List</h1>
        <a href="movies/create" style="float:right">
            <button class="btn btn-info">New Movie</button>
        </a>
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Movie ID</th>
                <th>Title</th>
                <th>Movie Director</th>
                <th>Synopsis</th>
                <th>Duration</th>
                <th>Age</th>
                <th>Categories</th>
                <th>Casts</th>
                <th>Posterpath</th>
                <th>Thumbnail</th>
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
        $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('movies.index')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'director', name: 'director'},
                    {data: 'synopsis', name: 'synopsis'},
                    {data: 'time', name: 'time'},
                    {data: 'age', name: 'age'},
                    {data: 'categories', name: 'categories'},
                    {data: 'casts', name: 'casts'},
                    {data: 'posterpath', name: 'posterpath'},
                    {data: 'thumbnail', name: 'thumbnail'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "scrollX": true
            });

        });
    </script>
@endpush



