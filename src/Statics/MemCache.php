<?php
declare(strict_types=1);

namespace Statics;

/**
 * Class MemCache
 *
 * Handles static memory caching — NOT TO BE CONFUSED with `memcached`.
 */
class MemCache {
	/**
	 * Static property to hold items stored in memory and indexed by handle.
	 *
	 * @var array
	 */
	private static array $mem = [];

	/**
	 * Runs an example showing how to use static mem stream.
	 *
	 * @return void
	 */
	public static function runExample(): void {
		MemStream::init();
		$context = stream_context_create(['staticmem'=>['custom'=>"foo"]]);
		$handle = MemCache::newHandle();
		$fp     = fopen( MemCache::getStreamUrl( $handle ), "r+", false, $context);
		fwrite( $fp, "line1\n" );
		fwrite( $fp, "line2\n" );
		fwrite( $fp, "line3\n" );
		rewind( $fp );
		while ( ! feof( $fp ) ) {
			echo fgets( $fp );
		}
		fclose( $fp );
		var_dump( MemCache::getValue( $handle ) );
		MemCache::closeHandle( $handle );
	}

	/**
	 * Generates a new unique handle (key) into the internal self::$mem array.
	 *
	 * @return int The unique handle.
	 */
	public static function newHandle(): int {
		do {
			// Generate a random number between 1,000,000 and 9,999,999
			$handle = mt_rand( 1000000, 9999999 );
		} while ( array_key_exists( $handle, self::$mem ) ); // Ensure the handle is unique

		// Add the handle to the memory array
		self::$mem[ $handle ] = '';

		// Return the unique handle
		return $handle;
	}

	/**
	 * Gets the URL to use with fopen(), Phar(), etc.
	 *
	 * @param int $handle The handle for which to get the URL.
	 *
	 * @return string The URL associated with the handle.
	 */
	public static function getStreamUrl( int $handle ): string {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );

		return "staticmem://{$handle}";
	}

	/**
	 * Sets the value stored by handle in static memory.
	 *
	 * @param int $handle The handle for which to set the value.
	 * @param string $value The value to be stored.
	 *
	 * @return void
	 */
	public static function setValue( int $handle, string $value ): void {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );
		self::$mem[ $handle ] = $value;
	}

	/**
	 * Concatenates to a value stored by handle in static memory.
	 *
	 * @param int $handle The handle for which to concatenate the value.
	 * @param string $value The value to concatenate.
	 *
	 * @return void
	 */
	public static function concatValue( int $handle, string $value ): void {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );
		self::$mem[ $handle ] .= $value;
	}

	/**
	 * Gets the value stored by handle in static memory.
	 *
	 * @param int $handle The handle for which to get the value.
	 *
	 * @return string|null The value stored or null if not found.
	 */
	public static function getValue( int $handle ): ?string {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );

		return self::$mem[ $handle ];
	}

	/**
	 * Gets a substring of the value stored by handle in static memory.
	 *
	 * @param int $handle The handle for which to get the substring.
	 * @param int $pos The start position of the substring.
	 * @param int $count The length of the substring.
	 *
	 * @return string|null The substring or null if not found.
	 */
	public static function getSubstrValue( int $handle, int $pos, int $count ): ?string {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );

		return substr( self::$mem[ $handle ], $pos, $count );
	}

	/**
	 * Gets the string length of the value stored for the handle in static memory.
	 *
	 * @param int $handle The handle for which to get the string length.
	 *
	 * @return int The length of the stored value.
	 */
	public static function getSize( int $handle ): int {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );

		return strlen( self::$mem[ $handle ] );
	}

	/**
	 * "Closes" the handle and releases related memory.
	 *
	 * @param int $handle The handle to be closed.
	 *
	 * @return void
	 */
	public static function closeHandle( int $handle ): void {
		/** @noinspection PhpUnhandledExceptionInspection */
		self::checkHandle( $handle );
		unset( self::$mem[ $handle ] );
	}

	/**
	 * Checks if the handle is valid.
	 *
	 * @param int $handle The handle to check.
	 *
	 * @return void
	 * @throws \Exception If the handle is not valid.
	 */
	public static function checkHandle( int $handle ): void {
		if ( ! array_key_exists( $handle, self::$mem ) ) {
			/** @noinspection PhpUnhandledExceptionInspection */
			throw new \Exception( "Invalid static memory handle: {$handle}" );
		}
	}

	/**
	 * Returns the internal array (for debugging).
	 *
	 * @return array The internal memory array.
	 */
	public static function getMem(): array {
		return self::$mem;
	}

}
