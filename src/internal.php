<?php

// File: /src/A/A.php
namespace A;
use A\B\B;
class A {
	function __construct() {
		// valid
		$b = new B();
	}
}

namespace A\B;
class B {}

namespace A\B\C;
use A\B\B;
class C {
	function __construct() {
		// valid
		$b = new B();
	}
}

// File: /src/A/D/D.php
namespace A\D;
use A\B\B;
class D {
	function __construct() {
		// visibility error
		$b = new B();
	}
}

// File: /src/C/C.php
namespace C;
use A\B\B;
class C {
	function __construct() {
		// visibility error
		$b = new B();
	}
}




namespace _;
use A\A;
use A\B\C\C as ABCC;
$a = new A();
print_r($a);

$a = new ABCC();
print_r($a);

