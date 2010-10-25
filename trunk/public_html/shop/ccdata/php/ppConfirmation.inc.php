<?php
/**
* CoffeeCup Software's Shopping Cart Creator.
*
* Template for presenting PayPal error reports.
*
* @version $Revision: 2265 $
* @author Cees de Gruijter
* @category SCC
* @copyright Copyright (c) 2009 CoffeeCup Software, Inc. (http://www.coffeecup.com/)
*/
?>
<html>
<head>
    <title>PayPal - ExpressCheckoutPayment</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
		<br>
		<center>
		<font size=2 color=black face=Verdana><b>ExpressCheckoutPayment</b></font>
		<br><br>

		<b><?php echo _T('Thank you for your payment!' ); ?></b><br><br>


    <table width =400>

        <tr>
            <td>
                <?php echo _T('Transaction ID:'); ?></td>
            <td><?=$myPage->resArray['TRANSACTIONID'] ?></td>
        </tr>
        <tr>
            <td >
                <?php echo _T('Amount:'); ?></td>
            <td><?=$myPage->resArray['CURRENCYCODE']?> <?=$myPage->resArray['AMT'] ?></td>
        </tr>
    </table>
    </center>
    <a class="home" id="CallsLink" href="index.php">Home</a>
</body>
</html>
