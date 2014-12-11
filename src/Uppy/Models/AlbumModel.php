<?php namespace Hostbrute\Uppy\Models;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Support\Facades\View;
use Orchestra\Model\Eloquent;

class AlbumModel extends Eloquent implements StaplerableInterface
{
	use EloquentTrait;

	public $timestamps = false;
	public $fillable = ['name', 'description'];
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'uppy_albums';

	/**
	 *
	 */
	public function __toString()
	{
		$this->pictures()->get();
		return View::make('hostbrute/media::albums.show', ['album' => $this])->render();
	}

	public function pictures()
	{
		return $this->belongsToMany('Hostbrute\Uppy\Models\PictureModel', 'uppy_album_pictures', 'album_id', 'picture_id');
	}
}
