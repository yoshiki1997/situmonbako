<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;

class Pagenator {

    public function __construct()
    {

    }

    public function Pagenator($questions){
    
        $currentPage = request()->get('page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $questions = new LengthAwarePaginator(
                    array_slice($questions['questions'], $offset, $perPage),
                    count($questions['questions']),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()]
                    );

        return $questions ;
    }
    
    public function youtubePagenator($videos){
    
        $currentPage = request()->get('page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $videos = new LengthAwarePaginator(
                    array_slice($videos, $offset, $perPage),
                    count($videos),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()]
                    );

        return $videos ;
    }

    public function QittaPagenator($qittaposts){
    
        $currentPage = request()->get('page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $qittaposts = new LengthAwarePaginator(
                    array_slice($qittaposts, $offset, $perPage),
                    count($qittaposts),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()]
                    );

        return $qittaposts ;
    }

    public function RankingsPagenator($rankings){
    
        $currentPage = request()->get('page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $videos = new LengthAwarePaginator(
                    array_slice($rankings, $offset, $perPage),
                    count($rankings),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()]
                    );

        return $rankings ;
    }
}