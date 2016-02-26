<?php

namespace PHPLegends\ThumbLaravel;

use Illuminate\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;
use PHPLegends\Thumb\Thumb as BaseThumb;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class Thumb
{

	/**
	* @var \Illuminate\Routing\UrlGenerator;
	*/
	protected $url;

	/**
	* @var \Illuminate\Html\HtmlBuilder;
	*/
	protected $html;

	public function __construct(UrlGenerator $url, HTMLBuilder $html)
	{
		$this->url = $url;

		$this->html = $html;
	}

	public function url($image, $width, $height)
	{	
		$thumb = $this->create($image, $width, $height);

		return $this->url->to($thumb->urlize());
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

		return $this->html->image($url, $alt, $attributes, $secure = null);
	}

	public function create($image, $width, $height)
	{
		return new BaseThumb($image, $width, $height);
	}

}