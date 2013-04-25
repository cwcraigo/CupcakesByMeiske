<?php
/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 23, 2012
* DESCRIPTION: View images for CupcakesByMeiske.cwcraigo.com.
************************************************************************ */
// declaring variables.
$picture_array = array();

// getting message if exists.
if (!empty($_SESSION['error'])) {
	$error = $_SESSION['error'];
}
if (!empty($_SESSION['message'])) {
	$message = $_SESSION['message'];
}

?>

<?php require_once $current_dir.'/modules/header.php'; ?>

<div id="content" >
	<p class="errorMessage" ><?php if (!empty($error)) echo $error; ?></p>
	<p><?php if (!empty($message)) echo $message; ?></p>
<?php
	if(!empty($_SESSION['picture_array'])) {
		$picture_array = $_SESSION['picture_array'];
		echo "<h1>Images</h1>";
		echo "<div id='outsidePicFrame' >";
		foreach ($picture_array as $key) {
			echo "<div class='picAndComment' >";
			if (!empty($_SESSION['loginStatus']) && $_SESSION['loginStatus'] == TRUE) {
				echo '<div class="deletePicDiv" ><button type="button" class="deletePicButton" onclick="window.location.href=\'index.php?action=deletePic&amp;picID='.$key['picture_id'].'\'" >X</button></div>';
				echo "<div class='picFrame'><img src='".$key['thumbnail']."' class='myPics' ></div>";
				echo "<form method='POST' action='.' id='editPicForm' >
								<textarea name='description' cols='40' rows='2' >".$key['description']."</textarea>
								<input type='hidden' name='ID' value='".$key['picture_id']."' />";
				echo '<div class="editPicDiv" ><input type="submit" class="editPicButton" name="action" value="Edit Desc" /></div></form>';
			} else {
				echo "<div class='picFrame'><img src='".$key['thumbnail']."' class='myPics' ></div>";
				echo "<p>".$key['description']."</p>";
			}
			echo "</div>";
		}
		echo "</div>";
	} else {
		echo "<p>Sorry, no Pictures at this time.</p>";
	}

	?>

<?php require_once $current_dir.'/modules/footer.php'; ?>



