<?php

namespace PHPLegends\ThumbLaravel;

use PHPLegends\Thumb\Thumb as BaseThumb;
use Illuminate\Foundation\Application;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class Thumb
{

	protected $app;

	/**
	* @var string
	*/

	protected $publicPath = 'public';

	/**
	* @var string
	*/

	protected $thumbPath = '_thumbs';

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function url($image, $width, $height = 0)
	{	

		$urlizer = $this->getUrlizer($image);

		$imageFile = $urlizer->getPublicFilename(); 

		$destiny = $urlizer->buildThumbFilename(
			md5($image . $width . $height)
		); 

		$filename = $this->create($imageFile, $width, $height)
						  ->save($destiny)
						  ->getFilename();
		
		$thumbUrl = $urlizer->getThumbUrlPath() . '/' . $filename;

		return $this->app['url']->to($thumbUrl);
	}

	public function image($image, $alt = null, $attributes = array(), $secure = null)
	{

		if(! isset($attributes['height']) && ! isset($attributes['width'])) {

			throw new \UnexpectedValueException(
				'The attribute #height or #width is required'
			);
		}

		$height = array_get($attributes, 'height');

		$width = array_get($attributes, 'width');

		$url = $this->url($image, $width, $height);

		return $this->app['html']->image($url, $alt, $attributes, $secure = null);
	}

	public function create($image, $width, $height)
	{
		return new BaseThumb($image, $width, $height);
	}

	public function getUrlizer($imageFile)
	{
		$urlizer = new Urlizer($imageFile);

		$config = $this->app['config']->get('thumb::config.php');

		$publicPath = array_get($config, 'public_path', 'public');

		$thumbPath = array_get($config, 'thumb_path', '_thumbs');

		$urlizer->setPublicPath($publicPath);
		
		$urlizer->setThumbPath($thumbPath);

		return $urlizer;
	}

}