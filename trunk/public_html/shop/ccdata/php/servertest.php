<?php
/**
 * CoffeeCup Software's Shopping Cart Creator.
 *
 * This script should include all tests for server capabilities that have shown to be problematic.
 *
 * Functional:
 *  1. on first page load, the page is displayed with 'Testing...' for all tests.
 *  2. javascript then reloads page $numberOfTests times, once for each test; the 'loop counter' is $sestest.
 *  3. each test is executed for its $sestest value, eg session on 1, curl on 2, etc.
 *  4. test results should be saved in myForm if the test is slow because we cannot depend on $_SESSION to work.
 *
 * Notes:
 *	Browser MUST support javascript.
 *	Use datainfo.php for all tests that depend on SCC data and sript versions
 *
 * 	This PHP file does not use any includes or other dependencies to make it easier to
 * 	distribute and to keep it as simple as possible.
 *
 *
 * @version $Revision: 2250 $
 * @author Cees de Gruijter
 * @category SCC
 * @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
 */
	define('MINEXECTIME', 20);

	session_start();

	$numberOfTests = 7;

	if( isset( $_SERVER['PATH_TRANSLATED'] )  || isset( $_SERVER['ORIG_PATH_TRANSLATED'] ) ) {
		$absPath = './';
	} else {
		$absPath = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
	}

	// page reload counter
	if( isset($_POST['sestest']) ) {
		$sestest = $_POST['sestest'] + 1;
	} else {
		$sestest = 0;
	}

	// tests are fast, so no need to cache result
	$extensions = testExtensions( $extMsg );
	$sessState = testSession( );
	$versionOK = testVersion( $version );
	$structOK = testFileStructure( $structMsg );
	$exeTime = testExecutionTime( $exeTimeMsg );
	$serverOK = testServerConfig ( $serverMsg );


	if( ! $extensions ) {
		$connectPPOK = -1;		// test can not be done safely
		$connectGCOK = -1;		// test can not be done safely
	} else {
		if ( $sestest == 3) {
			$connectPPOK = testPayPal( $connectPPMsg );
		} else {
			// this test is sloooooow if it fails on time out, so cache result
			if( isset($_POST['connectPPOK']) ) {
				$connectPPOK = $_POST['connectPPOK'];
				$connectPPMsg = stripslashes( $_POST['connectPPMsg'] );
			}
		}
		if ( $sestest == 4) {
			$connectGCOK = testGoogleCheckout( $connectGCMsg );
		} else {
			// this test is sloooooow if it fails on time out, so cache result
			if( isset($_POST['connectGCOK']) ) {
				$connectGCOK = $_POST['connectGCOK'];
				$connectGCMsg = stripslashes( $_POST['connectGCMsg'] );
			}
		}
	}

	#phpinfo();


/***** only test functions below this line ******/

function testServerConfig ( &$message ) {

	if( isset( $_SERVER['HTTP_HOST'] ) )
		$servername = $_SERVER['HTTP_HOST'];
	else
		$servername = $_SERVER['SERVER_NAME'];

	if( isset( $_SERVER["REDIRECT_SCRIPT_URI"] ) ) {
		$message = 'Is this the correct url of this site: "<b>'
				 . $servername
				 . '</b>"? If not, there might be a problem connecting to payment gateways.';
	} else {
		$message = 'Url to reach site : "<b>' . $servername . '</b>".';
	}

	if( isset( $_SERVER["SERVER_SOFTWARE"] ) )
		$message .= '<br> Web server software: ' . $_SERVER["SERVER_SOFTWARE"];

	$message .= '<br>Guest operating system: ' . PHP_OS . '.';

	return true;
}


function testVersion ( &$version ) {
	$version = phpversion();
	$v = explode('.', $version);

	$ok = false;
	$ok = $ok || $v[0] > 4;
	$ok = $ok || $v[0] = 4 && $v[1] >= 3;

	$add = array();
	// see if this is not some sneaky server
	if( isset( $_SERVER['PATH_TRANSLATED']) ) {
		$add[] = 'PATH_TRANSLATED';
	}
	if( isset( $_SERVER['REDIRECT_DOCUMENT_ROOT']) ) {
		$add[] = 'REDIRECT_DOCUMENT_ROOT';
	}
	if( isset( $_SERVER['ORIG_PATH_TRANSLATED']) ) {
		$add[] = 'ORIG_PATH_TRANSLATED';
	}

	if( !empty( $add ) ) {
		$version .= '<br>(hmmm, found '
				  . implode( ', ', $add )
				  .	'; settings that on rare occasions were an indication of problems)';

	}

	return $ok;

}


function testSession ( ) {
	// session should contain something upon subsequent visits
	if( isset($_SESSION['testid']) ) {
		$sessState = 'started';
	} else {
		$_SESSION['testid'] = 1;
		$sessState = 'new';
	}
	return $sessState;
}


function testExtensions ( &$message ) {
	$result = true;
	$exts = get_loaded_extensions();

	if( array_search('curl', $exts) === false )	{
		$result = false;
		$message .= "CURL missing, PayPal and Google Checkout don't work without this module. ";
	} else {
		// some 'free' servers disable curl_init
		$funcs = get_extension_funcs("curl");
		if( $funcs !== false && array_search('curl_init', $funcs) === false ) {
			$result = false;
			$message .= "CURL_INIT missing, PayPal and Google Checkout will not work. ";
		}
	}

	if( array_search('pcre', $exts) === false ) {
		$result = false;
		$message .= "PCRE missing, the shopping cart does not work without this extension. ";
	}

	if( array_search('session', $exts) === false ) {
		$result = false;
		$message .= "SESSION missing, the shopping cart will not be able to save products. ";
	}

	return $result;
}


function testPayPal ( &$message ) {

	if( file_exists("../data/data.php") ) {
		include "../data/data.php";
		$ppurl = $config['PayPal']['API_ENDPOINT'];
	} else {
		$ppurl = "https://www.paypal.com";
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $ppurl );
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// should return true on success
	$dummy = curl_exec($ch);
	$errno = curl_errno($ch);
	$errmsg = curl_error($ch);
	curl_close($ch);

	if( $dummy === false ) {

		// try a http connection too, you never know...
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://www.google.com");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		if( curl_exec($ch) ) {
			$message = "The necessary HTTPS connection to PayPal failed, but a request to e.g. http://www.google.com succeeded. This may indicate that Curl is working correctly but that the ISP has not configured HTTPS correctly. Check with their helpdesk, may be you need to configure a proxy.";
		} else {
			$message = "This server does not communicate with PayPal via HTTPS, which is necessary to process payment transactions.";
		}
		curl_close($ch);

		$message .= " The reported error is: [" . $errno . " - " . $errmsg . "] when connection to " . $ppurl;
	}
	return $dummy !== false ;
}


function testGoogleCheckout ( &$message ) {

	if( file_exists("../data/data.php") ) {
		include "../data/data.php";
		$ggurl = $config['Google']['url'];
	} else {
		$ggurl = "https://checkout.google.com/";
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $ggurl );
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// should return true on success
	$dummy = curl_exec($ch);
	$errno = curl_errno($ch);
	$errmsg = curl_error($ch);
	curl_close($ch);
	if( $dummy === false ) {
		$message = "This server does not communicate with Google Checkout via HTTPS, which is necessary to process payment transactions.";
		$message .= " The reported error is: [" . $errno . " - " . $errmsg . "] when connection to ". $ggurl;
		return false;
	}
	return true;
}


function testExecutionTime ( &$message ) {
	$message = ini_get('max_execution_time');
	// should be more than 20 s for PayPal connectivity
	return	ini_get('max_execution_time') + 0 > MINEXECTIME;
}


function testFileStructure ( &$message ) {

	global $absPath;

	// minimum file sizes of required files
	$fls['page.cls.php'] = 12000;
	$fls['cartcontrol.inc.php'] = 4000;
	$fls['common.inc.php'] = 2000;
	$fls['shoppingCart.cls.php'] = 12000;
	$fls['utilities.inc.php'] = 2000;
	$fls['ppConfirmation.inc.php'] = 500;
	$fls['ppApiError.inc.php'] = 1500;
	$fls['../data/data.php'] = 1000;

	if( strpos( strtoupper(PHP_OS), 'WIN' ) === 0 ) {
		$absPath = './';
	} else {
		$absPath = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
	}

	foreach( $fls as $name => $size ) {
		if( ! file_exists( $absPath . $name ) || filesize( $absPath . $name ) < $size ) {
			$message = "File '" . $absPath . $name . "' does not exist or is significantly smaller than expected.";
			return false;
		}
	}

	// minimum file sizes of optional files
	$fls2['checkoutgc.cls.php'] = 6000;
	$fls2['checkoutpp.cls.php'] = 6000;
	$fls2['checkoutans.cls.php'] = 5000;
	foreach( $fls2 as $name => $size ) {
		if( file_exists( $absPath . $name ) && filesize( $absPath . $name ) < $size ) {
			$message = "File '" . $absPath . $name . "' is significantly smaller than expected.";
			return false;
		}
	}

	// folders that should contain files, relative to where this script is
	$dirs = array( 'data' , 'images', 'js', 'template', '../css', '../images', /* '../js', '../..'*/ );
	if( !isset( $_SERVER['PATH_TRANSLATED'] ) && !isset( $_SERVER['ORIG_PATH_TRANSLATED'] ) ) {
		$dirs[] = '../..';
	}

	foreach( $dirs as $dir ) {

		$path = realpath( $absPath . '../' . $dir );
		if( ! $path || ! is_dir( $path ) ) {
			$message = "Path '" . $absPath . '../' . $dir . "' does not exist or is not a directory.";
			return false;
		}

		$handle = opendir( $path );

		if( $handle ) {

			$filecount = 0;
			while( false !== ( $file = readdir($handle) ) ) {

				$message .= $file . " ";

				if( $file != "." && $file != ".." && !is_dir( $path . "/". $file) && filesize( $path . "/". $file ) == 0 ) {

					$message = "File '" . $path . "/". $file . "' has size of 0 bytes.";
					return false;

	        	} else {
	        		++$filecount;
	        	}
	    	}

	    	closedir( $handle );

	    	if( $filecount == 0 ) {
				$message = "Directory '" . $path . "' does not contain files.";
				return false;
	    	}

		} else {
			$message = "Directory '" . $path . "' could not be opened.";
			return false;
		}
	}
	return true;
}



/***** only presentation stuff below this line ******/
?>


<html>
<head>
	<script type="text/javascript">

	</script>
	<style type="text/css">
h1 {font-size: 120%;}
dl {margin-left: 12px;}
dt {font-weight: bold;}
dd {font-style: italic;margin-bottom: 12px;}
	</style>
</head>
<body>
	<noscript style="color:red;font-weight:bold;">This test page requires JavaScript!</noscript>
	<form name="myForm" method="post">
		<input type="hidden" name="sestest" value="<?php echo $sestest ?>">
		<input type="hidden" name="connectPPOK" value="<?php echo $connectPPOK ?>">
		<input type="hidden" name="connectPPMsg" value="<?php echo $connectPPMsg ?>">
		<input type="hidden" name="connectGCOK" value="<?php echo $connectGCOK ?>">
		<input type="hidden" name="connectGCMsg" value="<?php echo $connectGCMsg ?>">
	</form>
	<h1>CoffeeCup Shopping Cart Server Validator.</h1>
<dl>
	<dt>Server Configuration</dt>
	<dd>
<?php
		echo $serverMsg;
?>
	</dd>

	<dt>PHP Version</dt>
	<dd>
<?php
		if( $versionOK ) {
			echo "OK - installed version of PHP on this server is: " . $version . ".";
		} else {
			echo "FAILED - the minimum PHP version needed id 4.4.x, while this server has $version installed.";
		}
?>
	</dd>
	<dt>PHP Extensions</dt>
	<dd>
<?php
	if( $sestest == 0 )
		echo "Testing...";
	else if( $extensions )
		echo "OK - found all PHP features needed to run the cart scripts.";
	else
		echo "FAILED - the PHP version on this server misses one or more extensions that are needed for the cart (or certain functions of an extension are disabled): $extMsg";
?>
	</dd>
	<dt>Session Data</dt>
	<dd>
<?php
	if( $sestest < 2 )
		echo "Testing...";
	else if( $sessState == 'started' )
		echo "OK - successfully wrote and read session data.";
	else
		echo "FAILED - this server can not store cart data for users.";
?>
	</dd>
		<dt>Connectivity with PayPal</dt>
	<dd>
<?php
	if( $sestest < 3 )
		echo "Testing...";
	else if( $connectPPOK > 0 )
		echo "OK - successfully contacted the PayPal server.";
	else if( $connectPPOK < 0 )
		echo "Test not executed due to failed previous tests.";
	else
		echo "FAILED - " . $connectPPMsg;
?>
	</dd>
	</dd>
		<dt>Connectivity with Google Checkout</dt>
	<dd>
<?php
	if( $sestest < 4 )
		echo "Testing...";
	else if( $connectGCOK > 0 )
		echo "OK - successfully contacted the Google Checkout server.";
	else if( $connectGCOK < 0 )
		echo "Test not executed due to failed previous tests.";
	else
		echo "FAILED - " . $connectGCMsg;
?>
	</dd>
	<dt>Maximum Execution Time Allowed</dt>
	<dd>
<?php
	if( $sestest < 5 )
		echo "Testing...";
	else if( $exeTime )
		echo "OK - server allows scripts to run for " . $exeTimeMsg . " seconds.";
	else
		if( empty($exeTimeMsg) )
			echo "WARNING - test could not retrieve the maximum execution time set for to PHP scripts. "
				. "A max exec time of " . MINEXECTIME . " seconds or longer is recommended.";
		else
			echo "WARNING - this server has a maximum execution time set to <b>only "
			   .  $exeTimeMsg. " seconds</b>, this may be too short to communication with PayPal or Google Checkout servers. "
			   . "A max exec time of " . MINEXECTIME . " seconds or longer is recommended.";
?>
	</dd>
	<dt>File Structure</dt>
	<dd>
<?php
	if( $sestest < 6 )
		echo "Testing...";
	else if( $structOK )
		echo "OK - all directories are present and accessible, no empty files have been encountered.";
	else
		echo "WARNING - " . $structMsg . " This may not be a problem, test the functioning of your shop itself."
		    . " This test is not reliable on servers that are not Linux/Unix (see test on PHP version if this may be the case).";
?>
	</dd>

	</dd>

</dl>
<?php if( $sestest == $numberOfTests ) {
	echo "Finished testing.";
	}
?>
</body>
<script type="text/javascript">
	// schedule x page reloads for each test
	if( parseInt(document.myForm.sestest.value) < <?php echo $numberOfTests; ?> ) {
		window.setTimeout("document.myForm.submit();", 700);
	}
</script>
</html>
