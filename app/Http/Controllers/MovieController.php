<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{

    protected MovieRepositoryInterface $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->movieRepository->getMoviesWithPagination();
        return Inertia::render('Movies/Index', ['movies' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie):void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie):void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie):void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie):void
    {
        //
    }
}
