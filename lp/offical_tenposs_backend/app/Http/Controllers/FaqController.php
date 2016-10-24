<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Faq;
use App\Models\FaqType;

class FaqController extends Controller
{
    protected $entity;
    protected $faq_type;

    public function __construct(Faq $entity, FaqType $faq_type){
    	$this->entity = $entity;
    	$this->faq_type = $faq_type;
    }

    public function select_all(){
    	$type = $this->faq_type->with('faqs')->get();
    	return view('pages.faq',compact('type'));

    }


}
