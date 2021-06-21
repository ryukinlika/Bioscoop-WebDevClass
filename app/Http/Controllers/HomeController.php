<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::orderBy('id', 'desc')->get();

        return view('welcome', [
            'movies' => $movies,
            // 'categories' => $categories,
            'sort_type' => 'Latest'
        ]);
    }

    public function sort($by)
    {
        if ($by == 'oldest') {
            $movies = Movie::orderBy('id', 'asc')->get();
        } else if ($by == 'alphabetical') {
            $movies = Movie::orderBy('title')->get();
        } else {
            $movies = Movie::orderBy('id', 'desc')->get();
        }

        return view('welcome', [
            'movies' => $movies,
            'sort_type' => $by
        ]);
    }

    public function show($id)
    {
        $movie = Movie::find($id);
        $screening_id = DB::table('screening')->where('movie_id', $id)->pluck('id');
        $screening_time = DB::table('screening')->where('movie_id', $id)->orderBy('time', 'asc')->pluck('time');
        if(!$screening_id->isEmpty()) {
            $i = 0;
            while(true) {
                $screening_room = DB::table('screening')->where('id', $screening_id[$i])->value('auditorium_id');
                $seat = DB::table('auditorium')->where('id', $screening_room)->value('seats_no');
                $count_tickets = DB::table('reservation')->where('screening_id', $screening_id[$i])->count();
                if($count_tickets >= $seat) {
                    $i++;
                    if($i >= count($screening_id)) {
                        $screening_id = '';
                        break;
                    }
                    continue;
                } else if($count_tickets < $seat) {
                    $screening_id = $screening_id[$i];
                    break;
                }
            }

        } else if($screening_id->isEmpty()) {
            $screening_id = '';
        }
        // dd($screening_id);
        return view('movie.show', [
            'movie' => $movie,
            'screening' => $screening_id,
            'screening_time' => $screening_time
        ]);
    }

    public function reserve($mid, $time) {
        $screening_id = DB::table('screening')->where('time', $time)->where('movie_id', $mid)->pluck('id');
        $i = 0;
        while(true) {
            $auditorium_id = DB::table('screening')->where('id', $screening_id[$i])->value('auditorium_id');
            $count_seats = DB::table('auditorium')->where('id', $auditorium_id)->value('seats_no');
            $count_tickets = DB::table('reservation')->where('screening_id', $screening_id[$i])->count();
            if($count_tickets >= $count_seats) {
                $i++;
                if($i >= count($screening_id)) {
                    return redirect()->route('movie.show', $mid);
                }
                continue;
            } else if($count_tickets < $count_seats) {
                $screening_id = $screening_id[$i];
                break;
            }
        }
        // dd($count_tickets);
        // dd($count_seats);
        return redirect()->route('reserve.index', $screening_id);
    }
}
