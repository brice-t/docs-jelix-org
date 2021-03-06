<?php
/* comments & extra-whitespaces have been removed by jBuildTools*/
/**
 * Compress JS in templates
 * @package    jelix
 * @subpackage jtpl_block
 * @version    1
 * @author      Hadrien Lanneau <contact at hadrien dot eu>
 * @copyright  2008 Hadrien.eu
 */
function jtpl_block_common_jscompress($compiler,$begin,$params=array()){
	if($begin){
		$content=' ob_start();';
	}
	else{
		$content='
        $buffer = preg_replace(
                array(
                        "/\/\/.*\n/",
                        "/[\t\n]+/",
                        "/\/\*.*?\*\//"
                ),
                array(
                        " ",
                        " ",
                        " "
                ),
                ob_get_contents()
        ) . "\n";
        ob_end_clean();
        echo $buffer;';
	}
	return $content;
}
