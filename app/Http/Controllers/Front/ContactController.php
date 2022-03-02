<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact');
    }

    public function create(Request $request)
    {
        $contact = new Contact();

        $contact->contact_user_name     = $request->user_name;
        $contact->contact_user_phone    = $request->user_phone;
        $contact->contact_subject       = $request->contact_subject;
        $contact->contact_message       = $request->contact_message;

        $contact->save();

        return redirect(route('contact'));
    }
}
