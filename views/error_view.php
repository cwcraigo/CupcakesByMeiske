<?php
/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 17, 2012
* DESCRIPTION: Error page for CupcakesByMeiske.cwcraigo.com
************************************************************************ */

session_start();

if(!empty($_SESSION['error'])) {
	echo '<br /><p style="color:red;"><b>Error: '.$_SESSION['error'].'</b>';
	unset($_SESSION['error']);
} else {
	echo 'No error.';
}

?>
<br />
<a href='index.php' >GO BACK</a>