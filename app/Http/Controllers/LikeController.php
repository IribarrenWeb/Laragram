<?php

namespace App\Http\Controllers;

use App\Like;

class LikeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function like($image_id) {

		$user_id = \Auth::id();

		$isset_like = Like::where('user_id', $user_id)
			->where('image_id', $image_id)
			->count();

		if ($isset_like == 0) {

			$like = new Like;
			$like->user_id = $user_id;
			$like->image_id = (int) $image_id;
			$like->save();

			return response()->json([
				'response' => true,
			]);
		} else {
			return response()->json([
				'response' => false,
			]);
		}
	}

	public function dislike($image_id) {

		$user_id = \Auth::id();

		$like = Like::where('user_id', $user_id)
			->where('image_id', $image_id)
			->first();

		if ($like) {

			$like->delete();

			return response()->json([
				'response' => true,
			]);
		} else {
			return response()->json([
				'response' => false,
			]);
		}
	}

	public function show_likes() {
		$user = \Auth::user();

		$user_likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(12);

		return view('like.user', [
			'likes' => $user_likes,
			'user' => $user,
		]);
	}
}
