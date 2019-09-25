<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

	/**
	 * Like belongs to Image.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function image() {
		// belongsTo(RelatedModel, foreignKey = image_id, keyOnRelatedModel = id)
		return $this->belongsTo('App\Image', 'image_id');
	}

	/**
	 * Like belongs to User.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		// belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
		return $this->belongsTo('App\User', 'user_id');
	}
}

?>
