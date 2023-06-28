<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;

class Pagenator {

    public function __construct()
    {

    }

    public function Pagenator($questions){
    
        $currentPage = request()->get('questions_page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $questions = new LengthAwarePaginator(
                    array_slice($questions['questions'], $offset, $perPage),
                    count($questions['questions']),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()],
                    'page'
                    );

        return $questions ;
    }
    
    public function youtubePagenator($videos){
    
        $currentPage = request()->get('datas_page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $videos = new LengthAwarePaginator(
                    array_slice($videos, $offset, $perPage),
                    count($videos),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()],
                    'youtube_Page'
                    );

        return $videos ;
    }

    public function QittaPagenator($qittaposts){
    
        $currentPage = request()->get('qittaposts_page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $qittaposts = new LengthAwarePaginator(
                    array_slice($qittaposts, $offset, $perPage),
                    count($qittaposts),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()],
                    'qittaposts_Page'
                    );

        return $qittaposts ;
    }

    public function StackExchangePagenator($stackExchangeQuestions){
    
        $currentPage = request()->get('stackExchangeQuestions_page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $stackExchangeQuestions = new LengthAwarePaginator(
                    array_slice($stackExchangeQuestions, $offset, $perPage),
                    count($stackExchangeQuestions),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()],
                    'stackExchangeQuestions_Page'
                    );

        return $stackExchangeQuestions ;
    }

    public function RankingsPagenator($rankings){
    
        $currentPage = request()->get('rankings_page', 1);
                $perPage = 9;
                $offset = ($currentPage - 1) * $perPage;
                $rankings = new LengthAwarePaginator(
                    array_slice($rankings, $offset, $perPage),
                    count($rankings),
                    $perPage,
                    $currentPage,
                    ['path' => request()->url(), 'query' => request()->query()],
                    'rankings_Page'
                    );

        return $rankings ;
    }

    public function paginateArray($items, $perPage = 9, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}