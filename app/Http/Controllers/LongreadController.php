<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Longread;
use App\Models\BlockList;
use App\Models\Block;
use Auth;

class LongreadController extends Controller
{


	public function load(Request $request){
		$user = Auth::user();
		$data = $user->longreads;
		// dd($data);
		return view('longreads', compact('data'));
	}

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
		$blocks = $request->all();
		for ($i = 0; $i < count($blocks); $i++){
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
}
