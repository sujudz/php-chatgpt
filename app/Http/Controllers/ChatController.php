<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Setting;
use App\Models\Chat;
use App\Models\Prompt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Orhanerday\OpenAi\OpenAi;
use DfaFilter\SensitiveHelper;


class ChatController extends Controller
{
    public function index()
    {
        $prompts = $this->getPromptList();
        return Inertia::render('Chat/Index', ['chat' => array("title" => ""), 'prompts' => $prompts]);
    }

    protected function getPromptList() {
        return Prompt::list()
                ->get()
                ->transform(function ($prompt) {
                    return [
                        'id' => $prompt->id,
                        'title' => $prompt->title,
                        'desc' => $prompt->desc,
                        'icon' => $prompt->icon,
                        'icon_type' => $prompt->icon_type
                    ];
                });
    }

    protected function veriyKeyword($content) {
        $wordFilePath = getcwd() . KeywordFliterController::FILE_NAME;

        // get one helper
        $handle = SensitiveHelper::init()->setTreeByFile($wordFilePath);
       
        ### 检测是否含有敏感词
        $islegal = $handle->islegal($content);

        return $islegal;
    }

    public function store()
    {
        Request::validate([
            'title' => ['required', 'min:2']
        ]);

        $system = Setting::system()->transform(function ($system) {
            return [
                'id' => $system->id,
                'name' => $system->name,
                'value' => json_decode($system->value, true),
                'create_at' => $system->create_at,
            ];
        })->first();

        if ($system['value']['keyword_filter_switch'] == 'on' && $this->veriyKeyword(Request::get('title', ''))) {
            return Redirect::route('chat')->with('error', '包含敏感词');
        }
       	$open_ai_key = $system['value']['api_token'];
		$open_ai = new OpenAi($open_ai_key);

        $chatId = Request::get('id', '');
        $userId = Auth::user()->id;
        $chat = Chat::list($userId, $chatId);

        if (empty($chatId) || empty($chat)) {
            $chat = $this->createChat($userId, "");
            $chatId = $chat->id;
        }

        $forcezh = Request::get('forcezh', false);
        
        $promptTemplateId = Request::get('promptTemplateId', 0);

        $promptTemplateDesc = "";
        if (!empty($promptTemplateId)) {
            $promptTemplate = Prompt::single($promptTemplateId);
            $promptTemplateDesc = $promptTemplate->desc;
        }
        $prompt = $this->wrapPrompt(Request::get('title'), $chat, $promptTemplateDesc);
		$complete = $open_ai->completion([
		    'model' => 'text-davinci-002',
		    'prompt' => $prompt . (empty($forcezh) ? '' : ' 请用中文回复'),
		    'temperature' => 0.9,
		    'max_tokens' => 2048,
		    'frequency_penalty' => 0,
		    'presence_penalty' => 0.6
		]);

        $complete = json_decode($complete, true);

        if (!empty($complete) && !empty($complete['choices'])) {
            $this->updateChat($chat, $prompt, $complete['choices'][0]);
        }

        $chatId = empty($chat->id) ? '' : $chat->id;
        if (isset($complete['error'])) {
            //return Redirect::route('chat')->with('error', $complete['error']['message']);
        }

        $prompts = $this->getPromptList();
        return Inertia::render('Chat/Index', ['chat' => array("title" => "", "id" => $chatId), 'responseData' => $complete, 'prompts' => $prompts]);
    }

    protected function updateChat($chat, $prompt, $choice) {
        $chat->update(['value' => $prompt . $choice['text']]);
    }

    protected function createChat($userId, $data) {
        return Chat::create([
            'user_id' => $userId,
            'value' => $data
        ]);
    }

    private function wrapPrompt($prompt, $chat, $promptTemplateDesc) {
        $content = empty($chat) ? '': trim($chat->value) . "\n\n";

        $promptTemplateDesc = empty($promptTemplateDesc) ? '' : $promptTemplateDesc . " ";
        return $content . "me:$promptTemplateDesc$prompt";
    }
}
