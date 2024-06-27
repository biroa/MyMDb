<?php

namespace App\Http\Interfaces;

use mysql_xdevapi\Collection;

interface MovieRepositoryInterface {

    public function getMovieById(int $id):void;

    public function getMoviesWithPagination();

}
