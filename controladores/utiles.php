<?php


class Utiles{

	static public function diferenciaFechas($fechaInicial, $fechaFinal)
	{
		$dias = (strtotime($fechaInicial)-strtotime($fechaFinal))/(60*60*24);
		// $dias =abs($dias);
		$dias = floor($dias);
		return $dias;
	}

	static public function is_email($str)
	{
	  return (false !== strpos($str, "@") && false !== strpos($str, "."));
	}


/**
 *  Given a file, i.e. /css/base.css, replaces it with a string containing the
 *  file's mtime, i.e. /css/base.1221534296.css.
 *
 *  @param $file  The file to be loaded.  Must be an absolute path (i.e.
 *                starting with slash).
 */

	function auto_version($url){

	    $path = pathinfo($url);

	    if (file_exists($url)) {
	   		$ver = '.'.filemtime($url).'.';
	    	echo $path['dirname'].'/'.str_replace('.', $ver, $path['basename']);
	    }else{
	    	echo $url;
	    }

	}
		
} 



	


 ?>