<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Setting;
use App\Models\Prompt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Orhanerday\OpenAi\OpenAi;


class PromptController extends Controller
{
    public function index()
    {   
        return Inertia::render('Prompt/Index', [
            'prompts' => Prompt::list()
                ->paginate()
                ->transform(function ($prompt) {
                    return [
                        'id' => $prompt->id,
                        'title' => $prompt->title,
                        'desc' => $prompt->desc,
                        'icon' => $prompt->icon,
                        'icon_type' => $prompt->icon_type
                    ];
                })
        ]);
    }

    public function create()
    {
        return Inertia::render('Prompt/Create', []);
    }

    public function edit(Prompt $prompt)
    {
        return Inertia::render('Prompt/Edit', [
            'prompt' => [
                'id' => $prompt->id,
                'title' => $prompt->title,
                'desc' => $prompt->desc,
                'icon_type' => $prompt->icon_type,
                'icon' => $prompt->icon
            ]
        ]);
    }

    public function update(Prompt $prompt)
    {
        $prompt->update(
            Request::validate([
                'title' => ['required', 'min:3'],
                'desc' => ['required', 'min:5'],
                'icon_type' => [],
                'icon' => [],
            ])
        );

        return Redirect::back()->with('success', '编辑成功');
    }

    public function store()
    {
        Request::validate([
            'title' => ['required', 'min:3'],
            'desc' => ['required', 'min:5']
        ]);


       	Prompt::create([
            'title' => Request::get('title'),
            'desc' => Request::get('desc'),
            'icon_type' => Request::get('icon_type', 'none'),
            'icon' => Request::get('icon', ''),
        ]);

        return Redirect::route('prompt')->with('success', '添加成功');
    }

    public function delete(Prompt $prompt)
    {
        $prompt->delete();

        return Redirect::route('prompt')->with('success', '删除成功');
    }

}
