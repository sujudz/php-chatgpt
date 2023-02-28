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

class WriteController extends Controller
{
    public function index()
    {
    	$prompts = self::DEFAULT_PROMPT;
    	unset($prompts['none']);
        return Inertia::render('Write/Index', ["prompts" => $prompts]);
    }

    public function create() {

        $prompts = $this->getPromptList();

        $type = Request::get('type', 'none');
		$template = $this->getDefaultPrompt($type);
		$template['type'] = $type;
    	return Inertia::render('Write/Create', ["prompts" => $prompts, "template" => $template]);
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

    
       	$open_ai_key = $system['value']['api_token'];
		$open_ai = new OpenAi($open_ai_key);

        
        $userId = Auth::user()->id;

        $promptTemplateId = Request::get('promptTemplateId', 0);

        $promptTemplateDesc = "";
        if (!empty($promptTemplateId)) {
            $promptTemplate = Prompt::single($promptTemplateId);
            if (!empty($promptTemplate)) {
            	$promptTemplateDesc = $promptTemplate->desc;
            }
            
        }

        $type = Request::get('type', '');
        $defaultPrompt = $this->getDefaultPrompt($type);

        $title = Request::get('title', '');
        $subtitle = Request::get('subtitle', '');

        $prompt = str_replace("{title}", $title, $defaultPrompt['prompt']);
        $prompt = str_replace("{subtitle}", $subtitle, $prompt);

        $prompt = $this->wrapPrompt($prompt, $promptTemplateDesc);

		$complete = $open_ai->completion([
		    'model' => 'text-davinci-003',
		    'prompt' => $prompt,
		    'temperature' => 0.9,
		    'max_tokens' => 2048,
		    'frequency_penalty' => 0,
		    'presence_penalty' => 0.6
		]);

        $complete = json_decode($complete, true);

        $prompts = $this->getPromptList();
        return Inertia::render('Write/Create', ['responseData' => $complete, 'prompts' => $prompts]);
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

    const DEFAULT_PROMPT = [
    	"none" => [
    		"title" => "",
    		"link" =>"/write/create",
    		"desc" => "",
    		"icon" => "/img/write_icon/icon1.png",
    		"prompt" => ""
    	],
    	"blog" => [
    		"title" => "Blog Titles",
    		"link" =>"/write/create?type=blog",
    		"desc" => "Help you write the blog title and blog outline. You only need to provide some keywords and key information. AI will help you write",
    		"icon" => "/img/write_icon/icon1.png",
    		"prompt" => "Please help me write a blog title and outline. Here are the main keywords {title} of my blog title and of my blog content {subtitle}. You can write a title and outline for me based on these information"
    	],
    	"blogcontent" => [
    		"title" => "Blog Content",
    		"link" =>"/write/create?type=blogcontent",
    		"desc" => "To help you write blog content, you only need to provide some keywords and key information, and AI will help you write some fragments",
    		"icon" => "/img/write_icon/icon2.png",
    		"prompt" => "Please help me write a blog post according to these keywords {title} and the information ({subtitle}) in the brackets"
    	],
    	"business_ideas" => [
    		"title" => "Business Ideas",
    		"link" =>"/write/create?type=business_ideas",
    		"desc" => "There are good business startups, but they can't write a good copy. You only need to provide basic information to AI, and he can help you write it",
    		"icon" => "/img/write_icon/icon16.png",
    		"prompt" => "I have a business idea, this is his title: {title}, and some descriptions about it: {subtitle}, please help me write some business copy"
    	],
    	"fb_twitter_ad_about" => [
    		"title" => "Facebook, Twitter Ads About",
    		"link" =>"/write/create?type=fb_twitter_ad_about",
    		"desc" => "You don't have to think about it. The machine can help you write a copy of Facebook and Twitter advertising according to the keywords you provide",
    		"icon" => "/img/write_icon/icon9.png",
    		"prompt" => "I have these keywords :{title}. Please help me write a few copies of ads on Facebook and Twitter. For more copy information, please refer to this introduction :{subtitle}"
    	],
    	"product_description" => [
    		"title" => "Product Description",
    		"link" =>"/write/create?type=product_description",
    		"desc" => "Only one keyword and product feature description are needed, and the machine can help you create product introduction copy",
    		"icon" => "/img/write_icon/icon8.png",
    		"prompt" => "I have a product :{title} with the feature of :{subtitle}. Please help me write a copy of the product details page"
    	],
    	"seo_meta" => [
    		"title" => "SEO Meta Title Or Desc",
    		"link" =>"/write/create?type=seo_meta",
    		"desc" => "How to optimize the seo of the website? Enter the website title and approximate content, and the machine will help you generate seo info",
    		"icon" => "/img/write_icon/icon18.png",
    		"prompt" => "Please refer to these keywords :{title} and website description :{subtile}, to help me generate SEO titles and descriptions that Google and other search engines like"
    	],
    	"video_idea" => [
    		"title" => "Video Idea and Title",
    		"link" =>"/write/create?type=video_idea",
    		"desc" => "Just enter the keyword of the short video, and the machine can help you create a title suitable for various short video platforms",
    		"icon" => "/img/write_icon/icon15.png",
    		"prompt" => "This is the keyword :{title} and content introduction :{subtitle} of my video content. Please help me generate several short video titles"
    	],
    	"article_improvement" => [
    		"title" => "Article improvement",
    		"link" =>"/write/create?type=article_improvement",
    		"desc" => "AI can read your article and optimize it to make it look more literary.It can also improve the language errors of the article",
    		"icon" => "/img/write_icon/icon24.png",
    		"prompt" => "I want you to act as an English spelling corrector and improver. I hope you can replace my simplified A0 words and sentences with more beautiful, elegant and advanced English words and sentences. Keep the meaning unchanged, but make it more literary. I hope you can only reply to the corrected and improved content, and do not write an explanation.Here is the content:{title} {subtitle}"
    	]
    ];

    protected function getDefaultPrompt($type) {
    	if (!isset(self::DEFAULT_PROMPT[$type])) {
    		return self::DEFAULT_PROMPT['none'];
    	}

    	return self::DEFAULT_PROMPT[$type];
    }

    private function wrapPrompt($prompt, $promptTemplateDesc) {
        $content = "";

        $promptTemplateDesc = empty($promptTemplateDesc) ? '' : $promptTemplateDesc . " ";
        return $content . "$promptTemplateDesc$prompt";
    }
}
