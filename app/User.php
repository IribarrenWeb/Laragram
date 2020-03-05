<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'surname', 'nick', 'email', 'password','image'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * User has many Images.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function images() {
		// hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
		return $this->hasMany('App\Image');
	}

	/**
	 * User has many Comments.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comments() {
		// hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
		return $this->hasMany('App\Comment');
	}

	/**
	 * User has many Likes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function likes() {
		// hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
		return $this->hasMany(Like::class);
	}

}
