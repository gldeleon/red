<?php
	function dateRangeToText($date1, $date2, $ucfirst = false) {
		global $meses;

		$fiArray = explode("-", $date1);
		$ffArray = explode("-", $date2);
		$title = $ucfirst ? "D" : "d";
		$title .= "el ".$fiArray[2];
		if($date2 != $date1) {
			if($fiArray[1] == $ffArray[1])
				$title .= " al ".$ffArray[2];
		}
		$title .= " de ".ucfirst($meses[intval($fiArray[1], 10) - 1]);
		if($fiArray[0] != $ffArray[0])
			$title .= " de ".$fiArray[0];
		if($date2 != $date1) {
			if($fiArray[1] != $ffArray[1])
				$title .= " al ".$ffArray[2]." de ".ucfirst($meses[intval($ffArray[1], 10) - 1]);
		}
		$title .= " de ".$ffArray[0];

		return $title;
	}

	function array_key_extract($array, $key) {
		if(!is_array($array)) {
			echo "\n<b>Error:</b> Argument 0 must be an array.\n<br />";
			return false;
		}
		$pos = 0;
		foreach($array as $item => $value) {
			if($item == $key) {
				break;
			}
			$pos++;
		}
		$array = array_extract($array, $pos, true);

		return $array;
	}

	function array_extract($array, $pos, $mantain = false) {
		$pos = intval($pos);
		if($pos >= count($array)) {
			$resto = array();
			array_pop($array);
		}
		else {
			$resto = array_slice($array, $pos + 1, count($array), $mantain);
		}
		$res = array_slice($array, 0, $pos, $mantain);
		$res = array_union($res, $resto);

		return $res;
	}

	function array_union() {
		$numargs = func_num_args();
		$arg_list = func_get_args();
		$arg_error = false;
		for($i = 0; $i < $numargs; $i++) {
			if(!is_array($arg_list[$i])) {
				$arg_error = true;
				echo "<b>Error:</b> Argument {$i} must be an array.\n<br />";
				break;
			}
		}
		if(!$arg_error) {
			$res = array();
			for($i = 0; $i < $numargs; $i++) {
				foreach($arg_list[$i] as $key => $item) {
					$res[$key] = $item;
				}
			}
			return $res;
		}
		else
			return false;
	}

	function array_utf8_encode(&$value, $item, $uppercase = true) {
		$value = utf8_encode($value);
		if($uppercase) {
			$value = uppercase($value, false, false);
		}
	}

	function array_utf8_decode(&$value, $item, $uppercase = true) {
		$value = utf8_decode($value);
		if($uppercase) {
			$value = uppercase($value, false, false);
		}
	}

	function uppercase(&$string, $removeaccents = false, $isUTF8String = true) {
		if($isUTF8String) {
			$string = utf8_encode($string);
		}
		$string = mb_convert_case($string, MB_CASE_UPPER, "UTF-8");
		if($removeaccents) {
			$mayusculas = array("Á", "É", "Í", "Ó", "Ú", "Ü", "Ñ", "À", "È", "Ì", "Ò");
			$mayusculas2 = array("A", "E", "I", "O", "U", "U", "Ñ", "A", "E", "I", "O");
			$string = str_replace($mayusculas, $mayusculas2, $string);
		}

		return $string;
	}

	function lowercase(&$string, $removeaccents = false, $isUTF8String = true) {
		if($isUTF8String) {
			$string = utf8_encode($string);
		}
		$string = mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
		if($removeaccents) {
			$minusculas = array("á", "é", "í", "ó", "ú", "ñ", "ä", "ë", "ï", "ö", "ü", "ç");
			$minusculas2 = array("a", "e", "i", "o", "u", "ñ", "a", "e", "i", "o", "u", "z");
			$string = str_replace($minusculas, $minusculas2, $string);
		}

		return $string;
	}

	function rgb($hexval) {
		$hexval = str_replace("#", "", $hexval);
		$hexval = strtolower($hexval);
		$hexArray = str_split($hexval, 2);
		$decArray = array();
		foreach($hexArray as $item => $hex_string) {
			$decArray[] = hexdec($hex_string);
		}
		return $decArray;
	}

	function getColorGradient($num, $min = 0, $max = 100) {
		$colors = array(
			"#CD0000", "#D10000", "#D60000", "#DA0000", "#DE0000",
			"#E20000", "#E70000", "#EB0000", "#EF0000", "#F40000",
			"#F80000", "#FC0000", "#FF0000", "#FF0000", "#FF0000",
			"#FF0000", "#FF0000", "#FF0000", "#FF0000", "#FF0000",
			"#FF0000", "#FF0000", "#FF0000", "#FF0000", "#FF0000",
			"#FF0000", "#FF0000", "#FF0000", "#FF0000", "#FF0000",
			"#FF0000", "#FF0000", "#FF0000", "#FF0000", "#FF0000",
			"#FF0000", "#FF0000", "#FF0000", "#FF0000", "#FF0000",
			"#FF0700", "#FF1600", "#FF2300", "#FF3100", "#FF3E00",
			"#FF4A00", "#FF5900", "#FF6500", "#FF7400", "#FF7F00",
			"#FF8E00", "#FF9A00", "#FFA000", "#FFA700", "#FFAD00",
			"#FFB300", "#FFBA00", "#FFC000", "#FFC700", "#FFCB00",
			"#FFD200", "#FFD900", "#FFE000", "#FFE500", "#FFEB00",
			"#FFF100", "#FFF800", "#FFFE00", "#FFFF00", "#FFFF00",
			"#F4FB00", "#E2F300", "#CFEC00", "#BFE500", "#ACDE00",
			"#9CD700", "#89D000", "#79C900", "#68C300", "#57BC00",
			"#46B500", "#35AE00", "#23A700", "#12A000", "#009802",
			"#018C1A", "#028130", "#04744C", "#056864", "#065D7A",
			"#075786", "#084C9D", "#084C9D", "#084C9D", "#084C9D",
			"#084C9D", "#084C9D", "#084C9D", "#084C9D", "#084C9D"
		);

		if(is_int($num)) {
			if($num >= $max) {
				return $colors[count($colors) - 1];
			}
			else if($num <= $min) {
				return $colors[0];
			}
			else {
				$div = $max / count($colors);
				for($i = 1; $i <= count($colors); $i++) {
					if($num > 0 && $num <= ($i * $div) && $num < 3) {
						return $colors[$num];
					}
					else if($num > 0 && $num <= ($i * $div) && $num > 2) {
						return $colors[$i - 2];
					}
				}
			}
		}
		else {
			return "#909090";
		}
	}
?>