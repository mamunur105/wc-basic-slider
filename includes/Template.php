<?php

namespace Basic\Slider;


class Template{
	static function addTempleate($file,$data = array()){
		include BS_PATH."/templeate/{$file}.php";		
	}
}