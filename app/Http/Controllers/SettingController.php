<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function index()
    {
        $system = Setting::system()->transform(function ($system) {
                    return [
                        'id' => $system->id,
                        'name' => $system->name,
                        'value' => json_decode($system->value),
                        'create_at' => $system->create_at,
                    ];
                })->first();
        if (empty($system)) {
            $system = array(
                "value" => array()
            );
        }
        return Inertia::render('Setting/Index', ['system' => $system]);
    }

    public function update()
    {

        Request::validate([
            'appname' => ['required', 'min:4'],
            'api_token' => ['required', 'min:4']
        ]);

        $value = array(
                "api_token" =>Request::get('api_token'),
                "appname" => Request::get('appname'),
                "api_token_02" =>Request::get('api_token_02'),
                "api_token_03" =>Request::get('api_token_03'),
                "api_provider" => Request::get('api_provider'),
                "keyword_filter_switch" => Request::get('keyword_filter_switch')
            );
        Setting::system()->first()->update([
            'name' => "system",
            'value' => json_encode($value)
        ]);

        return Redirect::back()->with('success', '保存成功');
    }

    public function store()
    {
        Request::validate([
            'appname' => ['required', 'min:4'],
            'api_token' => ['required', 'min:4']
        ]);

        $value = array(
            	"api_token" =>Request::get('api_token'),
            	"appname" => Request::get('appname'),
            	"api_provider" => Request::get('api_provider')
            );
        Setting::create([
            'name' => "system",
            'value' => json_encode($value)
        ]);

        return Redirect::route('setting')->with('success', '保存成功');
    }
}
