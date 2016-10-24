<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    protected $contact;
    protected $request;

    public function __construct(Contact $contact, Request $request){
    	$this->contact = $contact;
    	$this->request = $request;
    }
    public function getContact(){
    	return view('pages.contact');
    }
    public function postContact(ContactRequest $contactRequest)
    {
    	// $data = [
    	// 	'company' => $contactRequest->input('company'),
    	// 	'bussiness' => $contactRequest->input('bussiness'),
    	// 	'fullname' => $contactRequest->input('fullname'),
    	// 	'nickname' => $contactRequest->input('nickname'),
    	// 	'phone' => $contactRequest->input('phone'),
    	// 	'email' => $contactRequest->input('email'),
    	// 	'reason' => $contactRequest->input('reason'),
    	// 	'message' => $contactRequest->input('message'),
    	// ];
    	// $this->contact->create($data);
    	// return redirect()->back()->with('mess','Thank you for your register!');
    	return redirect()->back()->with('mess','Thank you for your register!');
    }
}
