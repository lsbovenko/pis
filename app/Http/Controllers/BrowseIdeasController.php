<?php

namespace App\Http\Controllers;

/**
 * Class BrowseIdeasController
 *
 * @package App\Http\Controllers
 */
class BrowseIdeasController extends Controller
{
    const QUANTITY_ITEMS_ON_PAGE = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('browse-ideas.index', ['isShowSearchIdeaBlock' => true]);
    }
}
