<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

// use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function create()
	{
		return view('image.create');
	}

	public function save(Request $request)
	{

		// Validacion
		$validate = \Validator::make($request->all(),[
			'description' => 'required|max:255',
			'image_path' => 'required|image',
		]);

		if($validate->fails()){
			return response()->json(['status' => false, 'errors' => $validate->errors()]);
		}
		
		// Creacion del nombre de la imagen
		$image_path_name = time() . \Auth::id() . "_" . date("d-m-y") . ".{$request->image_path->extension()}";

		// Recoger datos
		$image_path = request('image_path')->storeAs('images', $image_path_name);

		$image = storage_path("app/") . $image_path;

		// Crear en handle de la imagen
		$image_resize = \ImageInt::make($image);

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

			$image_resize->fit(610);
		} else {
			$image_resize->resize(610, null, function ($constraint) {
				$constraint->aspectRatio();
			});
		}

		// Guardar imagen en el storage
		$image_resize->save();


		// Guardar imagen en la base de datos
		\Auth::user()->images()->create([
			'image_path' => $image_path_name,
			'description' => $request->description,
		]);

		// Redireccionar al perfil de usuario
		return response()->json(['status' => true, 'message' => 'Imagen subida'],201);
	}

	public function getImage($filename)
	{
		return response()->file(storage_path('app/images/') . $filename);
	}

	public function detail($image_id)
	{
		$image = Image::with('user','comments','likes')
				->findOrFail($image_id);
		
		return view('image.detail', compact('image'));
	}

	public function delete(Image $image)
	{

		$user = \Auth::user();

		if ($image->user_id == $user->id) {

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
			return redirect()->route('user.perfil', ['nick' => $user->nick]);

		} else {
			return redirect()->route('home')->with([
				'message' => 'Error al eliminar la publicacion.',
				'error' => true,
			]);
		}
	}

	public function edit(Image $image)
	{

		$user = \Auth::user();

		if (\Auth::check() && $image->user_id == $user->id) {

			return view('image.edit', ['user' => $user, 'image' => $image]);
		} else {
			return back()->with([
				'message' => 'Error: La imagen seleccionada no es valida.',
				'error' => true,
			]);
		}
	}

	/**
	 * Function to update the images descriptions
	 *
	 * @return void
	 */
	public function update()
	{

		// Validacion
		$data = request()->validate([
			'description' => 'required|max:255',
			'image_path' => 'image',
			'img_id' => 'required|integer',
		]);

		// Conseguir objeto 'Image'
		$image = Image::findOrFail($data['img_id']);

		// Creacion del nombre de la imagen
		$image_path_name = time() . \auth::id() . "_" . date("d-m-y") . ".{$data['image_path']->extension()}";

		// Guardar la nueva imagen y obtener su path
		$image_path = request('image_path')->storeAs('images', $image_path_name);

		$image_location = storage_path("app/") . $image_path;
		
		// Crear en handle de la imagen
		$image_resize = \ImageInt::make($image_location);

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
		$image_resize->save();

		Storage::disk('images')->delete(["{$image->image_path}"]);
		
		// Asignar el nuevo path_name y description al modelo de 'Imagen'
		$image->description = $data['description'];
		$image->image_path = $image_path_name;
		
		// Actualizar el objeto image con los nuevos datos
		$image->update();

		return redirect()->route('image.detail', ['id' => $data['img_id']])
			->with(['message' => 'Imagen actualizada correctamente']);
	}
}
