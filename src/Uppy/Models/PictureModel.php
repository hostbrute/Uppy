<?php namespace Hostbrute\Uppy\Models;


use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Orchestra\Model\Eloquent;

class PictureModel extends Eloquent  implements StaplerableInterface {
	use EloquentTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'uppy_pictures';
	public $timestamps = false;
	public $fillable = ['name',  'file'];

	public function __construct(array $attributes = array())
	{
		$this->hasAttachedFile('file', [
			'url' => '/uploads/uppy/:id/:style.:extension',
			'styles'	=> [
				'thumbnail'	=> [
					'dimensions'	=> 'x200',
					'auto-orient'	=> true,
					'convert_options'	=> ['quality' => 80]
				]
			]
		]);

		parent::__construct($attributes);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function album()
	{
		return $this->hasMany('Hostbrute\Uppy\Models\AlbumModel', 'album_id', 'picture_id');
	}
}
