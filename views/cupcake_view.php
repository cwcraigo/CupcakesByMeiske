<?php
/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 17, 2012
* DESCRIPTION: View for CupcakesByMeiske.cwcraigo.com.
************************************************************************ */
include_once $current_dir.'/lib/classes/cupcake_class.php';

// declaring variables.
$view_array = array();
$table_heading_array = array();
$title = $_SESSION['title'];

// getting message if exists.
if (!empty($_SESSION['error'])) {
	$message = $_SESSION['error'];
	unset($_SESSION['error']);
} elseif (!empty($_SESSION['message'])) {
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
}

if (!empty($_SESSION['multi_heading_array'])
		&& !empty($_SESSION['multi_array'])) {
	$multi_array = $_SESSION['multi_array'];
	$multi_heading_array = $_SESSION['multi_heading_array'];
}

// getting big array and heading array if exists
// else display that no content is available.
if(!empty($_SESSION['view_array'])
		&& !empty($_SESSION['table_heading_array'])) {
	$view_array = $_SESSION['view_array'];
	$table_heading_array = $_SESSION['table_heading_array'];
}

?>

<?php require_once $current_dir.'/modules/header.php'; ?>

<div id="content" >

	<h1><?php echo $title; ?></h1>
	<?php if (!empty($message)) echo '<p>'.$message.'</p>'; ?>

<?php
	// if not logged in print table instead of form.
	if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {

		echo '<div class="tabbable">';
		echo '<ul class="nav nav-tabs" id="myTab">
           <li class="active"><a href="#Cupcake Flavor" data-toggle="tab" >Cupcakes</a></li>
					 <li><a href="#Filling Flavor" data-toggle="tab" >Filling</a></li>
					 <li><a href="#Decoration" data-toggle="tab" >Decorations</a></li>
					 <li><a href="#Color" data-toggle="tab" >Colors</a></li>
					 <li><a href="#Prices" data-toggle="tab" >Prices</a></li>
          </ul>';

		for ($i=0; $i<5; $i++) {

							echo '<div class="tab-content" >';
							// print each heading
							foreach ($multi_heading_array[$i] as $key) {
								if ($key != 'Extra Charge'
									&& $key != 'Without Filling'
									&& $key != 'With Filling') {
									if ($key == 'Dozen') {
										echo "<div class='tab-pane'><h3 id='Prices' >Prices</h3>";
									} else {
                    if ($key == 'Cupcake Flavors') {
                      echo "<div class='tab-pane active'><h3 id='$key'>$key</h3>";
                    } else {
                      echo "<div class='tab-pane'><h3 id='$key'>$key</h3>";
                    }

									}
								} // end heading check
							} // end heading loop
							echo "<ul>";
							// loop through each row returned
							foreach ($multi_array[$i] as $array) {

								// loop through each column from row
								for ($j=0; $j<sizeof($array); $j++) {
									// if column is empty or date is zero's then empty string
									// else print column value in cell
									if ($multi_heading_array[$i][$j] == 'Dozen') {
										echo "<li>".$array[$j]." Dozen</li>";
									} elseif ($multi_heading_array[$i][$j] == 'With Filling') {
										echo "<li>".$array[$j]." with filling</li></ul>";
									} elseif ($multi_heading_array[$i][$j] == 'Without Filling') {
										echo "<ul><li>".$array[$j]." without filling</li>";
									} elseif (empty($array[$j]) || $array[$j] == '0000-00-00 00:00:00') {
										echo "";
									} else {
										echo "<li>".$array[$j]."</li>";
									}
								} // end row array.

							} // end for each
							echo "</ul></div>";

							// echo "<a href='#content' >Top</a></div>";

		} // end for loop
		echo '</div>';
	} else {

		// Insert button
		if ($title != 'No Content Available') {
			echo '<form method="POST" action="." id="insertForm" ><fieldset><legend>Add '.rtrim($title,'s').'</legend>';
			for ($i=0; $i < sizeof($table_heading_array); $i++) {
				if ($table_heading_array[$i] != "ID"
					&& $table_heading_array[$i] != "Date Removed"
					&& $table_heading_array[$i] != "Last Update Date") {
					// label
					echo "<label for='".$table_heading_array[$i]."'>".$table_heading_array[$i].": </label>";
					if ($table_heading_array[$i] == "Status") {
						echo '<select name="Status">
										<option value="ACTIVE" selected >ACTIVE</option>
										<option value="NOT_ACTIVE" >NOT_ACTIVE</option>
									</select>';
						echo "<br />";
					} else {
						echo "<input type='text' id='". $table_heading_array[$i] ."' name='". $i ."' /><br />";
					} // end input type check
				} // end heading check
			} // end loop
			echo '<input type="submit" name="action" value="Add '.rtrim($title,'s').'" class="insertButton" />';
			echo '</fieldset></form>';
		} // end insert button

		// if logged in
		// begin printing each result returned from model.
		foreach ($view_array as $array) {
			// beginning of form and field set.
			echo '<form method="POST" action="." class="myForm"><fieldset>';
			//loop through each column of the result.
			for ($i=0; $i < sizeof($array); $i++) {
				// if date values are zero's then set to empty string.
				if ($array[$i] == 'November 30, -0001 12:11AM' || $array[$i] == 'December 31, 1969') { $array[$i] = ''; }
				// print each label using the table_heading_array.
				if ($table_heading_array[$i] != 'ID') {
					echo "<label for='".$table_heading_array[$i]."'>".$table_heading_array[$i].": </label>";
				}
				// if ID/Last Update Date/Date Removed then set to be read only so user cannot change them.
				// creating drop down box for status
				// else print normal input field
				if ($table_heading_array[$i] == "ID") {
					echo "<input type='hidden' class='readonly' value='" .$array[$i]. "' id='". $table_heading_array[$i]."' name='".$table_heading_array[$i]."' readonly='readonly' />";
				} elseif ($table_heading_array[$i] == "Last Update Date") {
					echo "<span class='date'>".$array[$i]."</span><input type='hidden' class='readonly' value='" .$array[$i]. "' id='". $table_heading_array[$i]."' name='".$table_heading_array[$i]."' readonly='readonly' /><br />";
				} elseif ($table_heading_array[$i] == "Date Removed") {
					echo "<span class='date'>".$array[$i]."</span><input type='hidden' class='readonly' value='" .$array[$i]. "' id='". $table_heading_array[$i]."' name='date_removed' readonly='readonly' /><br />";
				} elseif ($table_heading_array[$i] == "Status" && $array[$i] == 'ACTIVE') {
					echo '<select name="Status">
									<option value="ACTIVE" selected >ACTIVE</option>
									<option value="NOT_ACTIVE" >NOT_ACTIVE</option>
								</select>';
					echo "<br />";
				} elseif ($table_heading_array[$i] == "Status" && $array[$i] == 'NOT_ACTIVE') {
					echo '<select name="Status">
									<option value="ACTIVE" >ACTIVE</option>
									<option value="NOT_ACTIVE" selected >NOT_ACTIVE</option>
								</select>';
					echo "<br />";
				} else {
					echo "<input type='text' value='" .$array[$i]. "' id='". $table_heading_array[$i] ."' name='". $i ."' /><br />";
				} // end input type check
			} // end loop result columns
			// form button
			echo '<input type="submit" name="action" value="Edit '.rtrim($title,'s').'" class="editButton" /><br />';
			echo '<input type="submit" name="action" value="Delete '.rtrim($title,'s').'" class="deleteButton" /></fieldset></form><br />';
		} // end foreach loop



	} // end check login

?>

<?php require_once $current_dir.'/modules/footer.php'; ?>