<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
	protected $table = 'images';

	/**
	 * Image has many Comments.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comments() {
		// hasMany(RelatedModel, foreignKeyOnRelatedModel = image_id, localKey = id)
		return $this->hasMany('App\Comment')->orderBy('id', 'desc');
	}

	/**
	 * Image has many Likes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function likes() {
		// hasMany(RelatedModel, foreignKeyOnRelatedModel = image_id, localKey = id)
		return $this->hasMany('App\Like')->orderBy('id', 'desc');
	}

	/**
	 * Image belongs to User.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		// belongsTo(RelatedModel, foreignKey = _id, keyOnRelatedModel = id)
		return $this->belongsTo('App\User', 'user_id');
	}
}
