<?php

namespace PHPLegends\ThumbLaravel;

use PHPLegends\Thumb\Thumb as BaseThumb;
use Illuminate\Foundation\Application;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class Thumb
{

	/**
	* @var \Illuminate\Foundation\Application
	*/
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	* Generate an url for image thumb
	* @param string $image
	* @param int $width
	* @param float $height
	*/
	public function url($image, $width, $height = 0, $cache = true)
	{	

		$urlizer = $this->getUrlizer($image);

		$imageFile = $urlizer->getPublicFilename(); 

		$thumbBasename = md5($image . $width . $height) . '-' . filemtime($imageFile);

		$destiny = $urlizer->buildThumbFilename($thumbBasename); 

		$saveMethod = $cache ? 'getCache' : 'save';

		$filename = $this->create($imageFile, $width, $height)
						  ->{$saveMethod}($destiny);
		
		$thumbUrl = $urlizer->buildThumbUrl($filename);

		return $this->app['url']->to($thumbUrl);
	}

	/**
	 * Generate an HTML image element.
	 *
	 * @param  string  $url
	 * @param  string  $alt
	 * @param  array   $attributes
	 * @param  bool    $secure
	 * @return string
	*/
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

	/**
	* Creates a new instance of \PHPLegends\Thumb\Thumb
	* @param string $image
	* @param float $width
	* @param float $height
	*/
	public function create($image, $width, $height)
	{
		return new BaseThumb($image, $width, $height);
	}

	/**
	* Retrives a instance of urlizer
	* @param string $image
	* @return \PHPLegends\ThumbLaravel\Urlizer
	*/
	protected function getUrlizer($image)
	{
		$urlizer = new Urlizer($this->app['url'], $image);

		$config = $this->app['config']->get('thumb::config');

		$thumbPath = array_get($config, 'folder', '_thumbs');
		
		$urlizer->setThumbPath($thumbPath);

		return $urlizer;
	}

}