<?php

/**
 * Gets the path to a versioned Mix file.
 *
 * Inspired by <https://www.sitepoint.com/use-laravel-mix-non-laravel-projects/>
 *
 * @since 1.0.0
 *
 * @param string $path The relative path to the file.
 * @param string $manifest_directory Optional. Custom path to manifest directory. Default 'build'.
 *
 * @return string The file URL.
 */
function mix( $path, $manifest_directory = 'build' ) {
	static $manifest;
	static $manifest_path;

	if ( ! $manifest_path ) {
		$manifest_path = get_theme_file_path( $manifest_directory . '/mix-manifest.json' );
	}

	// Bailout if manifest couldn’t be found
	if ( ! file_exists( $manifest_path ) ) {
		return get_theme_file_uri( $path );
	}

	if ( ! $manifest ) {
		// @codingStandardsIgnoreLine
		$manifest = json_decode( file_get_contents( $manifest_path ), true );
	}

	// Remove manifest directory from path
	$path = str_replace( $manifest_directory, '', $path );
	// Make sure there’s a leading slash
	$path = '/' . ltrim( $path, '/' );

	// Bailout with default theme path if file could not be found in manifest
	if ( ! array_key_exists( $path, $manifest ) ) {
		return get_theme_file_uri( $path );
	}

	// Get file URL from manifest file
	$path = $manifest[ $path ];
	// Make sure there’s no leading slash
	$path = ltrim( $path, '/' );

	return get_theme_file_uri( trailingslashit( $manifest_directory ) . $path );
}
