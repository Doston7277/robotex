<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::query()->with(['products'])->get();
        $cart = Cart::content();
        $cart_subtotal = Cart::subtotal();
        return view('front.contact' ,compact('cart_subtotal', 'categories', 'cart'));
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
