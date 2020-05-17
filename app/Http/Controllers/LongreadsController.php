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
	

	public function load(){
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
		$get_long = $requestData[0];
		$oldImg = $requestData[1];
		$deleteImg = $requestData[2];

		for ($i = 0; $i < count($oldImg); $i++){
			$c = 23;
			for ($j = 0; $j < count($oldImg[$i]); $j++){
				Storage::delete($oldImg[$i][$j]);
			}			
		}


		for ($i = 0; $i < count($deleteImg); $i++){
			for ($j = 0; $j < count($deleteImg[$i]); $j++){
				Storage::delete($deleteImg[$i][$j]);
			}
		}



		$d = Longread::where('id', '=', $requestData[0]["id"])->delete();

		
		// $c = $get_long["parameters"]["img"][0]["src"];
		if (empty($get_long["parameters"]["img"][0])) {
			$get_long["parameters"]["img"][0] = [];
		}
		else {
			if (substr_count($get_long["parameters"]["img"][0]["src"], '/storage/') == 0) {
				if (substr_count($get_long["parameters"]["img"][0]["src"], '../..') == 0) {
					// $c = 123;
					$cou = explode(',', explode(';', $get_long["parameters"]["img"][0]["src"])[1])[1];
					$search = [':', '-', ' '];
					$file = base64_decode($cou);

					$path = '/public/upload/' . str_replace($search, '_', date("Y-m-d H:i:s")) . $get_long["parameters"]["img"][0]["title"];				
					Storage::put($path, $file);
					$get_long["parameters"]["img"][0]["src"] = $path;
				}
				else {
					// $c = 1234;
					$get_long["parameters"]["img"][0]["src"] = $get_long["parameters"]["img"][0]["src"];
				}
			}	
			else {
				$get_long["parameters"]["img"][0]["src"] = $get_long["parameters"]["img"][0]["src"];
			}
		}
			

		Longread::create([
			'id' => $get_long["id"],
			'title' => $get_long["title"],
			'url' => $get_long["url"],
			'user_id' => $get_long["user_id"],
			'parameters' => json_encode($get_long["parameters"]),
		]);
		return $requestData;

		
	}

	public function deleteLongread(Request $request){
		$requestID = $request->all();
		$d = BlockList::where('longread_id', '=', $requestID)->delete();
		$c = Longread::where('id', '=', $requestID)->delete();
	}

	
}
