<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class KeywordFliterController extends Controller
{
	public const FILE_NAME = "/keyword_filter_words.txt";

    public function index()
    {	
    	$keywordFilterWord = file_get_contents(getcwd() . self::FILE_NAME);
        return Inertia::render('KeywordFilter/Index',['keywordFilterWord' => $keywordFilterWord]);
    }

    public function store()
    {	
    	Request::validate([
            'keywordFilterWord' => ['required', 'min:4']
        ]);

    	file_put_contents(getcwd() . self::FILE_NAME, Request::get('keywordFilterWord', ''));

        return Redirect::route('keyword_filter')->with('success', '保存成功');
    }
}
