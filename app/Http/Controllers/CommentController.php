<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class CommentController extends Controller {

	public function __construct() {
		// $this->middleware('auth');
	}

	public function create() {
		$data = request()->validate([
			'content' => 'required',
			'id' => 'required',
		]);	

		$user = Auth::user();
		$image_id = $data['id'];
		$content = $data['content'];
		$detail = request('detail');

		$comment = new Comment;
		$comment->image_id = $image_id;
		$comment->user_id = $user->id;
		$comment->content = $content;
		
		$result = $comment->save();

		$comment = $comment->fresh()->load('user');

		return response()->json([
			'user' => $user->nick,
			'comment' => $comment,
			'status' => $result,
		]);
	}

	public function delete($id, $image_id) {

		$comment = Comment::find($id);

		if ($comment && Auth::check() && ($comment->user->id == Auth::id() || $comment->image->user_id == Auth::id())) {
			$comment->delete();
			return back()->with(['message' => 'Comentario eliminado con exito.']);
		} else {
			return redirect()->route('image.detail', ['id' => $image_id])
				->with([
					'message' => 'Error al eliminar el comentario.',
					'error' => true,
				]);
		}

	}

	public function getOneComment(Image $image){
		$comments = $image->comments()->with('user')->get();

		if(!Arr::has($comments->first(),'content')){
			$data = [
				'status' => 200,
				'found' => false
			];
		}else{
			$data = [
				'status' => 200,
				'comments' => $comments,
				'found' => true
			];
		}
		
		return response()->json($data, $data['status']);
	}

}
