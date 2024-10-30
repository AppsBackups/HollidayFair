<?php

namespace App\Http\Controllers;


use App\Contact;
use App\SiteInformation;
use App\WebPage;
use Illuminate\Http\Request;

class WebPageController extends Controller
{
    public function homePage()
    {
        $dbCollection['data'] = WebPage::where('slug', '!=', 'privacy-policy')->where('slug', '!=',
            'term-condition')->get()->keyBy('slug');
       
        return view('web.welcome', $dbCollection);
    }

    public function privacyPage()
    {
        $dbCollection = WebPage::where('slug', '=', 'privacy-policy')->first();
        return view('web.privacy-policy', $dbCollection);
    }

    public function termPage()
    {
        $dbCollection = WebPage::where('slug', '=', 'term-condition')->first();
        return view('web.term-condition', $dbCollection);
    }

    public function faqPage()
    {
        $dbCollection = SiteInformation::where('site_slug', '=', 'faqs')->first();
        return view('web.faq', $dbCollection);
    }

    public function contactSubmit(Request $request)
    {
        $input = $request->all();
        $contact = Contact::create($input);
        if($contact)
        {
            return redirect()->route('/','#contact')->with('success','Message send successfully!');
        }
        return redirect()->route('/#contact','#contact')->with('error','Something went wrong, Please try again!');
    }

}
