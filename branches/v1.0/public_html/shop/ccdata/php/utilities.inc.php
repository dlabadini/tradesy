<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Stuff that comes in handy and/or is common to all pages.
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/

// absolute paths are more efficient (if possible), so is output buffering
//if( isset( $_SERVER['PATH_TRANSLATED'] ) || isset( $_SERVER['ORIG_PATH_TRANSLATED']) ) {

//note: 'Darwin' and Cygwin also contain 'win', but not at the first position
if( strpos( strtoupper(PHP_OS), 'WIN' ) === 0 ) {
	$absPath = './';
} else {
	$absPath = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
}
ob_start();

require $absPath . 'ccdata/php/page.cls.php';


// GetText-like translator
function _T( $text ) {

	global $myPage;
	static $lang = false;

	// load language table if necessary
	if( ! $lang ) {
		$file = $myPage->getLangIncludePath( 'language.dat.php' );
		if( file_exists( $file ) ) {
			$handle = fopen( $file, "r");
			$sdat = fread( $handle, filesize( $file ) );
			fclose( $handle );
			$lang = unserialize( $sdat );
		}
	}

	if( ! empty( $lang ) && isset($lang[$text]) ) {
		return $lang[$text];
	} else {
		return $text;
	}
	return $text;
}


/* by setting $divider to 100, eg 1000 -> 10,00
 * WARNING: input may not contain decimals of cents when working with cents!
 */
function formatMoney ( $amount, $divider = 1 ) {
	if (is_float($amount) && $divider == 100) {
		$amount = round($amount);
	}
	$amount = moneyToFloat($amount);
	if (!$amount) return '';
	else $amount = $amount / $divider;
	return formatAmount($amount, 2);
}


function intToMoney ( $amount, $divider = 100 ) {
	formatAmount( (float)$amount / $divider, 2);
	if (!$amount)
		return '';
	else
		return formatAmount( (float)$amount / $divider, 2);
}


// split (almost) any money format into whole units and cents
function moneyToFloat ( $input ) {
	$re = '/^((?:[,.\s]?\d{1,3})+?)(?:[.,](\d\d))?$/';
	if (preg_match($re, trim($input), $match)) {
		$money = str_replace(array(',','.',''), '', $match[1])
        	   . '.' . (!isset($match[2]) || $match[2] == '' ? '00' : $match[2]);
	} else $money = '';
	return $money;
}


function moneyToInt ( $input ) {
	return moneyToFloat($input) * 100;
}


function formatAmount ( $number, $dec_places, $lng = 'en' ) {
	switch ($lng) {
	case 'en':
		$r = number_format($number, $dec_places, '.', ',');
		break;
	case 'nl':
	case 'es':
		$r = number_format($number, $dec_places, ',', '.');
		break;
	case 'fr':
		$r = number_format($number, $dec_places, ',', ' ');
		break;
	default:
		die("No definition found for language '{$lng}' in formatAmount.");
    }
	return $r;
}


function formatDateTime ( $udate, $lng, $fmt = '' ) {
	switch ($lng) {
	case 'nl':
		setlocale(LC_TIME, 'nl_NL');
		break;
	case 'es':
		setlocale(LC_TIME, 'es_ES');
		break;
	case 'en':
	default:
	setlocale(LC_TIME, 'en_eng');
	}
	if ($fmt)
		return strftime($fmt, $udate);
	else
		return strftime("%A, %d-%B-%Y %T", $udate);
}


// html safe encoding with to a certain max length
function maxLenEncode( $string, $maxlength = -1 ) {

	$string = htmlspecialchars( $string, ENT_NOQUOTES );

	if( $maxlength > 0 && strlen( $string ) > $maxlength ) {

		$string = substr( $string, 0, $maxlength );

		if( false !== ($p = strrpos( $string, '&') ) ) {

			$string = substr( $string, 0, $p );

		}
	}

	return $string;
}

?>
