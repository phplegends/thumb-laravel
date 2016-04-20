<?php

namespace PHPLegends\ThumbLaravel;
use Illuminate\Routing\UrlGenerator;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
* Works with filename to generate a public url for thumbs in Laravel
*/
class Urlizer
{

	/**
	* @var \Illuminate\Routing\UrlGenerator
	*/

	protected $url;

	/**
	* @var string
	*/
	protected $thumbPath;

	/**
	* @var string
	*/
	protected $relative;

	/**
	* 
	* @param string $relative
	*/
	public function __construct(UrlGenerator $url, $relative)
	{
		$this->url = $url;

		$this->relative = $relative;
	}

	/**
	* @return string
	*/
	public function getPublicPath()
	{
	    return public_path();
	}

	/**
	* Build the public filename
	* @param string $image 
	*/
	public function getPublicFilename()
	{
	    return $this->getPublicPath() . '/' . $this->relative;
	}

	/**
	* Set directory to use by stores thumb (into public path)
	* @param string $path
	* @return \PHPLegends\ThumbLaravel\Urlizer
	*/
	public function setThumbPath($path)
	{
	    $this->thumbPath = trim($path, '/');

	    return $this;
	}

	/**
	* Retrieves the for thumbpath
	* @return string
	*/
	public function getThumbUrlPath()
	{
	    return '/' . $this->thumbPath;
	}

	/**
	* @return string
	*/
	public function getThumbPath()
	{
		return $this->getPublicPath() . '/' . $this->thumbPath;
	}

	/**
	* Builds the filename for thumb image
	* 
	* @return string
	*/
	public function buildThumbFilename($filename)
	{
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		if (! $extension) {

			$filename .= '.' . pathinfo($this->relative, PATHINFO_EXTENSION);
		}

		return $this->getThumbPath() . '/' . $filename;
	}

	/**
	* Builds the thumb url for image
	* @return string
	*/
	public function buildThumbUrl($filename)
	{
		return $this->url->to($this->getThumbUrlPath(), [$filename]);
	}

}