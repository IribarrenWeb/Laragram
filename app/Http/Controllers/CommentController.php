<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function create(Request $request) {

		$validate = $request->validate([
			'content' => 'required',
			'id' => 'required',
		]);

		$user_id = \Auth::id();
		$image_id = $request->input('id');
		$content = $request->input('content');
		$detail = $request->input('detail');

		$comment = new Comment;
		$comment->image_id = $image_id;
		$comment->user_id = $user_id;
		$comment->content = $content;

		$comment->save();

		if ($detail == 'true') {
			// $route = 'image.detail', [];
			return back();
		}

		return redirect()->route('home')->with(['message' => 'Comentario agregado']);
	}

	public function delete($id, $image_id) {

		$comment = Comment::find($id);

		if ($comment && \Auth::check() && ($comment->user->id == \Auth::id() || $comment->image->user_id == \Auth::id())) {
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

}
