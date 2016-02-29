#PHPLegends/ThumbLaravel

This package provices a easy way for image thumb creation in Laravel.

#Installation

Add package name in `composer.json` and run `composer update`.

```json
"require" : {
	"phplegends/thumb-laravel" : "1.*"
}
```


Add in your config/app.php file

```php
'PHPLegends\ThumbLaravel\ThumbServiceProvider'
```


And use the Facade class


```php
'alias' => array(
    'Thumb' => 'PHPLegends\ThumbLaravel\Facade'
)
```

For create thumb of image:

```php
Thumb::image('img/logo.png', $width, $height)
```

By default, the output directory is setted to `public/_thumbs`. For changes, `app/config/packages/phplegends/thumb-laravel/config.php` file.

```php
return array(
	'folder' => 'my_thumb_directory'
)
```

After this, all thumbs are storage in `public/my_thumb_directory`.


For make uncached image thumb, use `Thumb::image('url', 50, 50, false)`.
