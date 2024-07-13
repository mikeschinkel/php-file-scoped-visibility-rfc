<?php
declare(strict_types=1);

namespace Statics;

/**
 * Class MemStream
 *
 * A class to handle stream operations on static memory.
 */
class MemStream {
	const STREAM = 'staticmem';

    /**
     * @var mixed $context Stream context set by stream code.
     */
	public mixed $context;

    /**
     * @var int $position Current position in the stream.
     */
	private int $position;

    /**
     * @var int $handle Handle for the static memory.
     */
	private int $handle;

    /**
     * Opens a stream.
     *
     * @param string $path The path to open.
     * @param string $mode The mode in which to open the stream.
     * @param int $options Additional options.
     * @param string|null $opened_path Path that was opened.
     * @return bool True on success, false on failure.
     * @throws \Exception If the handle is invalid.
     */
    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path): bool {
	    print_r(stream_context_get_options($this->context));
	    exit(1);


	    $url = parse_url($path);
		$this->handle = (int)$url["host"];
		try {
			MemCache::checkHandle( $this->handle );
		} catch (\Exception $e) {
			/** @noinspection PhpUnhandledExceptionInspection */
			throw new \Exception("Invalid staticmem stream handle: '{$path}'; expected 'staticmem://<valid_int_handle>'");
		}
		$this->position = 0;
		return true;
	}

    /**
     * Reads from the stream.
     *
     * @param int $count Number of bytes to read.
     * @return string The data read from the stream.
     */
    public function stream_read(int $count): string {
		$result = MemCache::getSubstrValue($this->handle, $this->position, $count);
		$this->position += strlen($result);
		return $result;
	}

    /**
     * Writes to the stream.
     *
     * @param string $data The data to write.
     * @return int The number of bytes written.
     */
    public function stream_write(string $data): int {
		$value=MemCache::getValue($this->handle);
		$written=strlen($data);
		MemCache::setValue($this->handle,
			substr($value, 0, $this->position)
			. $data
			. substr($value, $this->position += $written)
		);
		return $written;
	}

    /**
     * Returns the current position in the stream.
     *
     * @return int The current position.
     */
	public function stream_tell():int {
		return $this->position;
	}

    /**
     * Checks if the end of the stream has been reached.
     *
     * @return bool True if end of stream, false otherwise.
     */
	public function stream_eof():bool {
		return $this->position >= MemCache::getSize($this->handle);
	}

    /**
     * Seeks to a position in the stream.
     *
     * @param int $offset The offset to seek to.
     * @param int $mode The mode to use for seeking.
     * @return bool True on success, false on failure.
     */
	public function stream_seek(int $offset, int $mode):bool {
		$size = MemCache::getSize($this->handle);
		switch ($mode) {
			case SEEK_SET: $newPos = $offset; break;
			case SEEK_CUR: $newPos = $this->position + $offset; break;
			case SEEK_END: $newPos = $size + $offset; break;
			default: return false;
		}
		$result = ($newPos >=0 && $newPos <=$size);
		if ($result) {
			$this->position = $newPos;
		}
		return $result;
	}

	/**
     * Registers the stream wrapper protocol.
     *
	  * @return void
     * @throws \Exception If registration fails.
	 */
    public static function init(): void {
		if (!stream_wrapper_register(self::STREAM, MemStream::class)) {
			/** @noinspection PhpUnhandledExceptionInspection */
			throw new \Exception(sprintf("Failed to register %s:// protocol",self::STREAM));
		}
	}
}
