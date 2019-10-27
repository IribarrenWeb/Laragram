<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index() {
		
		return view('home');

	}

	/**
	 * Get all images with pagination
	 * 
	 * @return json Collection
	 */
	public function getImages(Request $request){

		$images = Image::with('user','comments','likes')->orderBy('id', 'desc')->paginate(4);

		return $images;
	}
}
