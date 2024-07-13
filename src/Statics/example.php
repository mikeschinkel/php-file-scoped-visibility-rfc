<?php
declare(strict_types=1);

spl_autoload_register(function (string $class) {
	if (preg_match("#^Statics\\\Mem(Cache|Stream)$#", $class)) {
		$class = str_replace('\\', '/', $class);
		include dirname(__DIR__) . "/{$class}.php";
	}
});
\Statics\MemCache::runExample();

