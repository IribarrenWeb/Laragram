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

		// Validar los datos recibidos
		$validate = $request->validate([

			'name' => 'required|string|max:100',
			'surname' => 'required|string|max:100',
			'nick' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($id)],
			'email' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($id)],

		]);

		// Guardar los datos en variables
		$name = $request->input('name');
		$surname = $request->input('surname');
		$nick = $request->input('nick');
		$email = $request->input('email');

		// Recibir la imagen
		$image_path = $request->file('image_path');
		if ($image_path) {

			// Asignarle un nombre unico a la imagen
			$image_name = time() . $image_path->getClientOriginalName();

			// Almacenar en la carpeta 'users' del 'storage' con el nombre especificado
			Storage::disk('users')->put($image_name, File::get($image_path));
			$user->image = $image_name;

		}

		// Asignar valores al usuario
		$user->name = $name;
		$user->surname = $surname;
		$user->nick = $nick;
		$user->email = $email;

		// Guardar cambios
		$user->update();

		// Redireccionar a 'config' con un alerta
		return redirect()->route('uconfig')->with(['message' => 'Usuario actualizado correctamente']);

	}

	public function getImage($nameimage) {

		// Obtener imagen del 'storage'
		$file = Storage::disk('users')->get($nameimage);

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

		// $fullname = DB::row("CONCAT(name,' ',surname) as fullname");

		$users = User::where('nick', 'LIKE', '%' . $query . '%')->orderBy('id', 'desc')->get();

		return response()->json([
			'usuarios' => $users,
			'status' => 'ok',
		]);

	}
}
