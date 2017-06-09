<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{
    App,
    Input
};


use Illuminate\Http\Request;
use App\Models\Idea;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('categories.index');
    }

}
