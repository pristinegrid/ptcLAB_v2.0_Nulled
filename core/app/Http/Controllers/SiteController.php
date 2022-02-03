<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'HOME';
            $in['slug'] = 'home';
            Page::create($in);
        }
        
        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','home')->firstOrFail();
        return view($activeTemplate . 'home', $data);
    }

   public function blog()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','blog')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'Blog';
            $in['slug'] = 'blog';
            Page::create($in);
        }
        $data['page_title'] = 'Blog';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','blog')->firstOrFail();
        $data['blogs'] = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->paginate(getPaginate());
        return view($activeTemplate . 'blog.blogs', $data);
    }

    public function blogDetail($id)
    {
        $page_title = "Blog Details";
        $blog = Frontend::findOrFail($id);
        if(!$blog || $blog->data_keys != 'blog.element'){
            return view('errors.404');
        }
        $blog->increment('view');
        $blogs = Frontend::where('data_keys','blog.element')->get();
        return view(activeTemplate() . 'blog.details', compact('page_title','blog','blogs'));
    }

    public function about()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','about')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'About';
            $in['slug'] = 'about';
            Page::create($in);
        }
        $data['page_title'] = 'About';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','about')->firstOrFail();
        return view($activeTemplate . 'about', $data);
    }

    
    public function pages($slug)
    {
        $activeTemplate = activeTemplate();
        $page = Page::where('tempname',$activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','contact')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'Contact';
            $in['slug'] = 'contact';
            Page::create($in);
        }
        $data['page_title'] = 'Contact';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','contact')->firstOrFail();
        return view($activeTemplate . 'contact', $data);
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    SupportAttachment::create([
                        'support_message_id' => $message->id,
                        'image' => uploadImage($image, $path),
                    ]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function lang($lang){
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function policy($id,$slug){
        $item = Frontend::where('id',$id)->where('data_keys','footer_link.element')->firstOrFail();
        $page_title = $item->data_values->title;
        return view(activeTemplate().'policy',compact('page_title','item'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json('Cookie accepted successfully');
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

}
