@extends('layouts.app')

@section('content')
<head>
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/style.css') }}">
</head>
<div class="container">

    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($movies as $movie)
                @if($loop->index==0)<div class="carousel-item active">
                    @else<div class="carousel-item">
                        @endif
                        <img src="{{asset($movie->posterpath)}}" alt="{{Str::substr($movie->posterpath, 4)}}" class="d-block w-100">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
        </div>
    </div>

    <div class="container">
    {{-- Search --}}
        <div class="container mt-5">
            <h3><strong>Looking for something to watch?</strong></h3>
            <div class="search">
                <input type="text" name="search" id="myInput" maxlength= "30" placeholder="e.g. Interstellar" class="search-bar">
            </div>
        </div>
        {{-- Search --}}
    </div>

    {{-- Filter --}}
    <div class="container">
        <div class="container mt-4">
            <div class="row">
                <div class="col-sm-1">
                    <div class="dropdown show">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort By
                        </a>
                       <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                           <a href="{{ route('home.sort', 'alphabetical') }}" class="dropdown-item sort">Alphabetical</a>
                           <a href="{{ route('home.sort', 'latest') }}" class="dropdown-item sort">Latest</a>
                           <a href="{{ route('home.sort', 'oldest') }}" class="dropdown-item sort">Oldest</a>
                       </div>
                    </div>
                </div>

                <div class="col-sm-1 mr-4">
                    <div class="dropdown show">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Age Rating
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item filter" value="G_fltr">G</button>
                            <button class="dropdown-item filter" value="PG_fltr">PG</button>
                            <button class="dropdown-item filter" value="PG-13_fltr">PG-13</button>
                            <button class="dropdown-item filter" value="R_fltr">R</button>
                            <button class="dropdown-item filter" value="NC-17_fltr">NC-17</button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-1 mr-2">
                    <div class="dropdown show">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Duration
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <button class="dropdown-item filter" value="> 2 hours"> > 2 hours</button>
                            <button class="dropdown-item filter" value="< 2 hours"> < 2 hours</button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-1 mr-4">
                    <div class="dropdown show">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Genre
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($movies as $movie)
                                @foreach ($movie->categories as $genre)
                                    <button class="dropdown-item filter" value="{{ $genre }}">{{ $genre }}</button>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Filter --}}

    <div class="container mt-5" id="myDIV">
        <h3><strong>Now Showing</strong></h3>
        <h3>Sort by: {{ ucfirst($sort_type) }}</h3>
        <div class="filter-result"></div>
        <div class="row">
            @foreach($movies as $movie)
                <a href="{{ route('movie.show', $movie->id)}}" id="{{ $movie->title }}" class="movie-title text-decoration-none">
                    <div class="col-4 mt-4">
                        <div class="movie">
                            <div class="movie-img" style="background-image: url('{{ asset($movie->posterpath) }}');"></div>
                            <div class="text-movie-cont">
                                <div class="mr-grid">
                                    <div class="col1">
                                        <h2 class="text-left">{{ $movie->title }}</h2>
                                        <ul class="movie-gen">
                                            <li>{{ $movie->age }} /</li>
                                            <p hidden>{{$movie->age}}_fltr</p>
                                            <li> {{ intval(($movie->time)/60) }}h{{ intval(($movie->time)%60) }}m /</li>
                                            <p hidden>{{ intval(($movie->time)/60) >= 2 ? "> 2 hours" : "< 2 hours"}}</p>
                                            <li>
                                                @foreach($movie->categories as $genre)
                                                    @if($loop->index == 0){{$genre}}
                                                    @else{{", ".$genre." "}}
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="mr-grid">
                                <div class="mr-grid actors-row ml-4">
                                    <div class="col1">
                                        <p class="movie-actors">
                                            @foreach($movie->casts as $actor)
                                                @if($loop->index == 0){{$actor}}
                                                @else{{", ".$actor}}
                                                @endif
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                                <div class="mr-grid actors-row ml-3 synopsis">
                                    {{$movie->synopsis}}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <script type="application/javascript">
        $(document).ready(function(){
            // Search bar
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myDIV a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Dropdown Filter
            $('.filter').on('click', function () {
                $(".filter-result").html("");
                var filter_value = $(this).val();

                $(".filter-result").append('<h4 style="color: black">Showing results for: '
                    + ((filter_value.split("_").pop() == "fltr") ? filter_value.slice(0, -5) : filter_value)
                    + '</h4><button class="btn btn-light rmv"><i class="fas fa-times"></i> Remove Filter</button>');
                $("#myDIV a").filter(function() {
                    $(this).toggle($(this).text().indexOf(filter_value) > -1)
                });
            });

            //Remove Filter
            $(document).on('click', '.rmv', function(){ //for dynamically created button
                $(".filter-result").html("")
                $("#myInput").val("")
                $("#myDIV a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf('') > -1)
                });
            });

            //Animate scroll
            $(".filter").click(function() {
                $('html,body').animate({
                        scrollTop: $("#myDIV").offset().top},
                    'slow');
            });

            //if search result is empty
            $("#myInput").on("keyup", function() {
                $(".filter-result").html("")
                if($('.movie:visible').length < 1) {
                    $(".filter-result").append('<h3 style="text-align:center">No results found</h3>')
                }
            });
            $(".filter").click(function() {
                if($('.movie:visible').length < 1) {
                    $(".filter-result").append('<h3 style="text-align:center">No results found</h3>')
                }
            });

            //Remove duplicate dropdown menu option
            var seen = {};
            $('.filter').each(function() {
                var txt = $(this).text();
                if (seen[txt])
                    $(this).remove();
                else
                    seen[txt] = true;
            });

        });
    </script>
@endsection
