<?php
class MyClass {
	private string $value;
	public function __construct(string $value) {
		$this->value = $value;
	}
	public function getValue():string {
		return $this->value;
	}
}
class MyPackage {
	public function newMyClass(string $value):object {
		return new MyClass($value);
	}
}
return new MyPackage();