<?php
/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 17, 2012
* DESCRIPTION: View for CupcakesByMeiske.cwcraigo.com.
************************************************************************ */
$title = 'Home';

// getting message if exists.
if (!empty($_SESSION['error'])) {
	$message = $_SESSION['error'];
} elseif (!empty($_SESSION['message'])) {
	$message = $_SESSION['message'];
}

?>

<?php require_once $current_dir.'/modules/header.php'; ?>

<div id="content" >

	<p><?php if (!empty($message)) echo $message; ?></p>

	<h1><?php echo $title; ?></h1>
	<h2>Gourmet cupcakes made to order from scratch!</h2>
	<p>Also check out my <a href="https://www.facebook.com/CupcakesByMeiske">Facebook</a> Page!</p>

<?php require_once $current_dir.'/modules/footer.php'; ?>