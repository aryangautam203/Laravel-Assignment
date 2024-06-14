<?php

// app/Http/Controllers/RssFeedController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class RssFeedController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the data
        $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $items = $response->json()['channel']['item'];

        // Search functionality
        $search = $request->input('search');
        if ($search) {
            $items = array_filter($items, function ($item) use ($search) {
                return stripos($item['title'], $search) !== false || stripos($item['description'], $search) !== false;
            });
        }

        // Sorting functionality
        $sort = $request->input('sort', 'title'); // Default sort by title
        usort($items, function ($a, $b) use ($sort) {
            return strcmp($a[$sort], $b[$sort]);
        });

        // Paginate the data
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($items, $offset, $perPage);

        $paginator = new LengthAwarePaginator($paginatedItems, count($items), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('rssfeed', [
            'data' => $paginator,
            'search' => $search,
            'sort' => $sort,
        ]);
    }
}
