<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

// use Intervention\Image\Facades\Image;

class ImageController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function create() {

		return view('image.create');

	}

	public function save(Request $request) {

		// Validacion
		$validate = $this->validate($request, [
			'description' => 'required|max:255',
			'image_path' => 'required|image',
		]);

		// Tambien se puede hacer la validacion de esta manera:
		// ***************************************************
		//
		// $validate = $request->validate([
		// 	'description' => 'required|max:255',
		// 	'image_path' => 'required|image',
		// ]);

		// Recoger datos
		$image_path = $request->file('image_path');
		$description = $request->input('description');

		// Recoger usuario identificado
		$user = \Auth::user();

		// Asignacion de valores al modelo 'Image'
		$image = new Image;
		$image->user_id = $user->id;
		$image->description = $description;

		if ($image_path) {

			// Creacion del nombre de la imagen
			$image_path_name = time() . $image_path->getClientOriginalName();

			// Crear en handle de la imagen
			$image_resize = \ImageInt::make($image_path);

			// Crear la ruta de almacenamiento de la imagen
			$storage_path = storage_path() . '/app/images/';

			// Capturar ancho y alto de la imagen
			$img_height = $image_resize->height();
			$img_width = $image_resize->width();

			// $storage_original_path = storage_path() . '/app/images/';
			// $thumbnailImage->save($originalPath . time() . $originalImage->getClientOriginalName());

			// Redimencionar la imagen
			if ($img_height == $img_width) {

				$image_resize->resize(610, 610, function ($constraint) {
					$constraint->aspectRatio();
				});

			} elseif ($img_height > $img_width && $img_height > 700) {

				$image_resize->resize(null, 700, function ($constraint) {
					$constraint->aspectRatio();
				});
			} elseif ($img_height < $img_width && $img_width > 610) {

				$image_resize->fit(610);
			} else {
				$image_resize->resize(610, null, function ($constraint) {
					$constraint->aspectRatio();
				});
			}

			// Guardar imagen en el storage
			$image_resize->save($storage_path . $image_path_name, 80);

			// Asignar el path_name al modelo de 'Imagen'
			$image->image_path = $image_path_name;

		}

		// Guardar imagen en la base de datos
		$image->save();

		// Redireccionar al home
		return redirect()->route('home')->with(['message' => 'La imagen se ha subido correctamente!']);
	}

	public function getImage($filename) {

		$image = Storage::disk('images')->get($filename);

		return new Response($image, 200);
	}

	public function detail($id) {

		$image = Image::find($id);

		return view('image.detail', ['image' => $image]);

	}

	public function delete($id) {

		$user = \Auth::user();
		$image = Image::find($id);

		if ($user && $image && $image->user_id == $user->id) {

			// Eliminar comentarios de la imagen
			if ($image->comments && count($image->comments) >= 1) {
				foreach ($image->comments as $comment) {
					$comment->delete();
				}
			}

			// Eliminar likes de la imagen
			if ($image->likes && count($image->likes) >= 1) {
				foreach ($image->likes as $like) {
					$like->delete();
				}
			}

			// Eliminar imagens almacenada
			Storage::disk('images')->delete($image->image_path);

			// Eliminar imagen de la base de datos
			$image->delete();

			// Redireccionar a la home
			return redirect()->route('home')->with([
				'message' => 'Publicacion eliminada.',
			]);
		} else {
			return redirect()->route('home')->with([
				'message' => 'Error al eliminar la publicacion.',
				'error' => true,
			]);
		}
	}

	public function edit($id) {

		$user = \Auth::user();
		$image = Image::find($id);

		if (\Auth::check() && $image && $image->user_id == $user->id) {

			return view('image.edit', ['user' => $user, 'image' => $image]);

		} else {
			return back()->with([
				'message' => 'Error: La imagen seleccionada no es valida.',
				'error' => true,
			]);
		}
	}

	public function update(Request $request) {

		// Validacion
		$validate = $this->validate($request, [
			'description' => 'required|max:255',
			'image_path' => 'image',
			'img_id' => 'required|integer',
		]);

		// Recoger datos
		$image_path = $request->file('image_path');
		$description = $request->input('description');
		$image_id = $request->input('img_id');

		// Conseguir objeto 'Image'
		$image = Image::find($image_id);
		$image->description = $description;

		if ($image_path) {

			// Creacion del nombre de la imagen
			$image_path_name = time() . $image_path->getClientOriginalName();

			// Crear en handle de la imagen
			$image_resize = \ImageInt::make($image_path);

			// Crear la ruta de almacenamiento de la imagen
			$storage_path = storage_path() . '/app/images/';

			// Capturar ancho y alto de la imagen
			$img_height = $image_resize->height();
			$img_width = $image_resize->width();

			// Redimencionar la imagen
			if ($img_height == $img_width) {
				$image_resize->resize(610, 610, function ($constraint) {
					$constraint->aspectRatio();
				});
			} elseif ($img_height > $img_width && $img_height > 700) {
				$image_resize->resize(null, 700, function ($constraint) {
					$constraint->aspectRatio();
				});
			} elseif ($img_height < $img_width && $img_width > 610) {
				$image_resize->fit(610, 300);
			} else {
				$image_resize->resize(610, null, function ($constraint) {
					$constraint->aspectRatio();
				});
			}

			// Guardar imagen en el storage
			$image_resize->save($storage_path . $image_path_name, 80);

			// Asignar el path_name al modelo de 'Imagen'
			$image->image_path = $image_path_name;

		}

		$image->update();

		return redirect()->route('image.detail', ['id' => $image_id])
			->with(['message' => 'Imagen actualizada correctamente']);

	}
}
