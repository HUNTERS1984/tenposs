<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
	protected $request;
	protected $photo;

	public function __construct(Request $request, Photo $photo){
		$this->request=$request;
		$this->photo=$photo;
	}
}
