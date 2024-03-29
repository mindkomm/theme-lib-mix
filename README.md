# Mix

A [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) function for WordPress themes.

The `mix()` function is useful if you want to enable **cache busting** for your theme asset files (CSS, JavaScript, images, icon sprites). Laravel Mix allows you to create a `mix-manifest.json` file, which might look like this:

```json
{
    "/css/styles.css": "/css/styles.css?id=6ed48b0b831e80bd7549",
    "/js/scripts.js": "/js/scripts.js?id=1bdd07b944e933aa88aa",
}
```

The ID parameter is a hash of the file contents that changes every time that you make a change to a file. The `mix()`, `mix_child()` and `mix_any()` functions provided in this package allow you to use these hashed URLs for enqueueing your assets in your WordPress theme.

## Installation

You can install the package via Composer:

```bash
composer require mindkomm/theme-lib-mix
```

## Usage

The `mix()` function assumes that you have a `mix-manifest.json` (generated by the [version function of Laravel Mix](https://github.com/JeffreyWay/laravel-mix/blob/master/docs/versioning.md)) in the `build` folder of your theme.

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'styles',
        mix( 'build/css/styles.css' )
    );
} );
```

If the mix function can’t find your asset file in the manifest file, it will return the asset URL through [`get_theme_file_uri`](https://developer.wordpress.org/reference/functions/get_theme_file_uri/) as a fallback.

## Functions

| Name | Return Type | Summary/Returns |
| --- | --- | --- |
| [mix()](#mix) | `string` | Gets the path to a versioned Mix file in a theme.<br><br>*Returns:* The versioned file URL. |
| [mix_child()](#mix_child) | `string` | Gets the path to a versioned Mix file in a **child theme**.<br><br>*Returns:* The versioned file URL. | 
| [mix_any()](#mix_any) | `string` | Gets the path to a versioned Mix file outside of your theme folders.<br><br>*Returns:* The versioned file URL. |

### mix()

Gets the path to a versioned Mix file in a theme.

Use this function if you want to load theme dependencies. This function will cache the contents of the manifest files for you.

- If you want to use mix in a child theme, use `mix_child()`.
- If you want to use mix outside of your theme folder, you can use `mix_any()`.

**since** 1.0.0 

`mix( string $path, array $args = [] )`

**Returns:** `string` The versioned file URL.

| Name | Type | Description                                                                                                                                                                                                                                                         |
| --- | --- |---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| $path | `string` | The relative path to the file.                                                                                                                                                                                                                                      |
| $args | `array` | Optional. An array of arguments for the function.<ul><li>*(bool)* **$is_child** – Whether to check the child directory first. Default `false`.</li><li>*(string)* **$manifest_directory** – Custom relative path to manifest directory. Default `build`.</li></ul> |

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'styles',
        mix( 'build/css/styles.css' )
    );
} );
```

### mix\_child()

Gets the path to a versioned Mix file in a child theme.

Similar to [`mix()`](#mix), but tries to load a file from the child theme first.

**since** 1.2.0

`mix_child( string $path, array $args = [] )`

```php
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style(
		'theme-styles-child',
		mix_child( 'build/css/styles-child.css' ),
		[],
		null
	);
} );
```

### mix\_any()

Gets the path to a versioned Mix file outside of your theme folders.

The difference to the `mix()` function is that for this function, you need to provide the absolute paths to the file and the manifest directory. The benefit is that it’s more versatile and that you can use it for functionality that might not live in a theme, but in a plugin, vendor packages or in a symlinked package.

**since** 1.1.0 

`mix_any( string $path, string $manifest_directory, string $manifest_name = mix-manifest.json )`

**Returns:** `string` The versioned file URL.

| Name | Type | Description |
| --- | --- | --- |
| $path | `string` | The full path to the file. |
| $manifest_directory | `string` | The full path to the manifest directory. |
| $manifest_name | `string` | Optional. The name of the manifest file in `$manifest_directory`. Default `mix-manifest.json`. |

---

## Support

This is a library that we use at MIND to develop WordPress themes. You’re free to use it, but currently, we don’t provide any support. 
