<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;

class MovieRepository implements MovieRepositoryInterface
{

    public function getMovieById($id):void
    {
        // TODO: Implement getMovieById() method.
    }

    public function getMoviesWithPagination()
    {
       return Movie::paginate(5);
    }
}
