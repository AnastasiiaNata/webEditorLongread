<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Longread;
use App\Models\BlockList;
use App\Models\Block;
use Auth;

class LongreadController extends Controller
{
	

	public function logout(){
		Auth::logout();
		return view('welcome');
	}

	// public function load(Request $request){
	// 	$user = Auth::user();
	// 	$data = $user->longreads;
	// 	// dd($data);
	// 	return view('longreads', compact('data'));
	// }

	public function loadLongread($id){
		$longreadId = $id;
		return view('longread', compact('longreadId'));
	}

	public function loadBlocks($id){
		$longread = BlockList::where('longread_id', '=', $id)->get();
		for ($i = 0; $i < count($longread); $i++){
			$fileName = Block::where('id', '=', $longread[$i]['block_id'])->get()[0]['fileName'];
			$longread[$i]['fileName'] = $fileName;
		} 
		$blocks = Block::all();
		$data = [];
		$data[0] = $longread;
		$data[1] = $blocks;
		return $data;
	}


	public function saveBlocks(Request $request, $id){ 	
		$d = BlockList::where('longread_id', '=', $id)->delete();
		$requestData = $request->all();
		$blocks = $requestData[0];
		$oldImg = $requestData[1];
		$deleteImg = $requestData[2];

		for ($i = 0; $i < count($oldImg); $i++){
			for ($j = 0; $j < count($oldImg[$i]); $j++){
				Storage::delete($oldImg[$i][$j]);
			}			
		}
		

		for ($i = 0; $i < count($deleteImg); $i++){
			for ($j = 0; $j < count($deleteImg[$i]); $j++){
				Storage::delete($deleteImg[$i][$j]);
			}
		}
		
		for ($i = 0; $i < count($blocks); $i++){
			for ($j = 0; $j < count($blocks[$i]["content"]["img"]); $j++){
				if (substr_count($blocks[$i]["content"]["img"][$j]["src"], '/storage/') == 0) {
					if (substr_count($blocks[$i]["content"]["img"][$j]["src"], '../..') == 0) {
						$cou = explode(',', explode(';', $blocks[$i]["content"]["img"][$j]["src"])[1])[1];
						$search = [':', '-', ' '];
						$file = base64_decode($cou);

						$path = '/public/upload/' . str_replace($search, '_', date("Y-m-d H:i:s")) . $blocks[$i]["content"]["img"][$j]["name"];				
						Storage::put($path, $file);
						$blocks[$i]["content"]["img"][$j]["src"] = $path;
					}
					else {
						$blocks[$i]["content"]["img"][$j]["src"] = $blocks[$i]["content"]["img"][$j]["src"];
					}
				}	
				else {
					$blocks[$i]["content"]["img"][$j]["src"] = $blocks[$i]["content"]["img"][$j]["src"];
				}		
			}
			

			if (array_key_exists('block_id', $blocks[$i])) {
				BlockList::create([
			    	'longread_id' => $id,
			    	'block_id' => $blocks[$i]["block_id"],
			    	'content' => json_encode($blocks[$i]["content"]),
			    	'styles' => json_encode($blocks[$i]["styles"]), 
				]);
			}
			else {
				BlockList::create([
			    	'longread_id' => $id,
			    	'block_id' => $blocks[$i]["id"],
			    	'content' => json_encode($blocks[$i]["content"]),
			    	'styles' => json_encode($blocks[$i]["styles"]), 
				]);
			}
		}
		return $request;
	}






	public function loadPreview($id){
		$longreadId = $id;
		return view('preview', compact('longreadId'));
	}

}
