<?php

namespace PHPLegends\ThumbLaravel;

class Urlizer
{

	protected $publicPath;

	protected $thumbPath;

	protected $relative;


	public function __construct($relative)
	{
		$this->relative = $relative;
	}

	/**
	* @param string $path
	* @return 
	*/
	public function setPublicPath($path)
	{
	    $this->publicPath = trim($path, '/');

	    return $this;
	}

	/**
	* @return string
	*/
	public function getPublicPath()
	{
	    return $this->publicPath;
	}

	/**
	* Build the public filename
	* @param string $image 
	*/
	public function getPublicFilename()
	{
	    return $this->getPublicPath() . '/' . $this->relative;
	}

	public function setThumbPath($path)
	{
	    $this->thumbPath = trim($path, '/');

	    return $this;
	}

	public function getThumbUrlPath()
	{
	    return '/' . $this->thumbPath;
	}

	public function getThumbPath()
	{
		return $this->getPublicPath() . '/' . $this->thumbPath;
	}

	public function buildThumbFilename($filename)
	{
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		if (! $extension) {

			$filename .= '.' . pathinfo($this->relative, PATHINFO_EXTENSION);
		}

		return $this->getThumbPath() . '/' . $filename;
	}

	public function buildThumbUrl($filename)
	{
		return $this->getThumbUrlPath() . '/' . $filename;
	}

}