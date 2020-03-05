<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {

		$users = User::where('id', '!=', \Auth::id())->orderBy('id', 'desc')->paginate(5);

		return view('user.index', ['users' => $users]);
	}

	public function config() {

		return view('user.config');

	}

	public function update(Request $request) {

		// Obtener id de usuario
		$user = Auth::user();
		$id = $user->id;

		if(!empty($request->password)){
			$rulesValidation = [
				'password' => 'required|max:10',
				'repassword' => 'required|max:10|same:repassword2',
				'repassword2' => 'required|max:10',
			];
		}elseif(!empty($request->file('image'))){
			$rulesValidation = [
				'image' => 'required|image'
			];
		}else{
			$rulesValidation = [
				'name' => 'required|alpha|max:10',
				'surname' => 'required|alpha|max:10',
				'nick' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($id)],
				'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($id)],
			];
		}

		// Validar los datos recibidos
		$validate = \Validator::make($request->all(),$rulesValidation);

		if($validate->fails()){

			return response()->json([
				'status' => false,
				'errors' => $validate->errors()
			],200);
		
		}elseif($request->password){

			$isValid = Auth::once(['id' => $user->id, 'password' => $request->password]);

			if($isValid){
				$upData = \Hash::make($request->only('password'));
			}
		
		}elseif($request->file('image')){
			
			$path = $request->file('image')->store($request->user()->id,'users');

			if($user->image !== 'default_avatar.png'){
				$exist = Storage::disk('users')->exists($user->image);
				if($exist){
					Storage::disk('users')->delete($user->image);
				}
			}
			// Almacenar en la carpeta 'users' del 'storage' con el nombre especificado
			$upData = ['image' => $path];
		
		}else{
			
			$upData = $request->only('name','surname','nick','email');
		
		}

		// Guardar cambios
		$result = $user->update($upData);

		// Redireccionar a 'config' con un alerta
		return response()->json(['status'=>$result],200);

	}

	public function getImage(Request $request) {
		if (!empty($request->user)) {
			$path = $request->user.'/'.$request->filename;
		}
		else{
			$path = $request->filename;
		}

		// Obtener imagen del 'storage'
		$file = Storage::disk('users')->get($path);

		// Enviar la imagen a la vista
		return new Response($file, 200);
	}

	public function perfil($nick) {

		$user = User::where('nick', $nick)->first();
		$images = Image::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(12);
		$likes = 0;

		// Recoger likes de las publicaciones del usuario
		foreach ($images as $image) {
			foreach ($image->likes as $like) {
				if ($like->user->id != $image->user->id) {
					$likes += 1;
				}
			}
		}

		return view('user.perfil', [
			'user' => $user,
			'images' => $images,
			'likes' => $likes,
		]);
	}

	public function search($query) {

		$users = User::where([
			['nick', 'LIKE', '%' . $query . '%'],
			['id','!=',\Auth::id()]
		])->orderBy('id', 'desc')->get();
		
		return response()->json([
			'users' => $users
		]);

	}

	public function getAuth(){
		return \Auth::user();
	}
}
