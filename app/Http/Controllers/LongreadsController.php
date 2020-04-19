<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Longread;
use App\Models\BlockList;
use App\Models\Block;
use Auth;

class LongreadsController extends Controller
{
	

	public function load(Request $request){
		$user = Auth::user();
		$data = $user->longreads;
		// dd($data);
		return view('longreads', compact('data'));
	}

	public function loadList(Request $request){
		$user = Auth::user();
		$data = $user->longreads;
		return $data;
	}

	public function create(Request $request){
		$user = Auth::user();
		$long = new Longread;
		$long->user_id = $user['id'];
		$long->save();
		$data = $user->longreads;
	}

	public function save(Request $request){
		$requestData = $request->all();
		return $request;
	}

	public function deleteLongread(Request $request){
		$requestID = $request->all();
		$d = BlockList::where('longread_id', '=', $requestID)->delete();
		$c = Longread::where('id', '=', $requestID)->delete();
	}

	
}
