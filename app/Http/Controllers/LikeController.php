<?php

namespace App\Http\Controllers;

use App\Like;
use App\Image;

class LikeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function like(Image $image) {

		$user_id = \Auth::id();
		$isset_like = $image->likes()->where('user_id', $user_id);

		if ($isset_like->count() == 0) {

			$like = new Like;
			$like->user_id = $user_id;
			$like->image_id = (int) $image->id;
			$like->save();

		} else {

			$isset_like->first()->delete();

		}

		$totalLikes = $image->fresh()->likes()->count();
		
		return response()->json([
			'response' => true,
			'total' => $totalLikes
		]);
	}


	public function show_likes() {
		$user = \Auth::user();

		$user_likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(12);

		return view('like.user', [
			'likes' => $user_likes,
			'user' => $user,
		]);
	}

	public function getLikes(){
		$image_id = request('id');
		$likes = Like::where('image_id', $image_id)->get();
		return response()->json([
			'likes' => count($likes),
		]);
	}
}
