<?php
/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 17, 2012
* DESCRIPTION: Main Index or Controller for CupcakesByMeiske.cwcraigo.com.
************************************************************************ */
// STARTING SESSION
session_start();
$_SESSION['session_id'] = session_id();

// DECLARATIONS
unset($_SESSION['title']);
unset($_SESSION['view_array']);
unset($_SESSION['message']);
unset($_SESSION['error']);
$_SESSION['title'] = "";
$_SESSION['message'] = "";
$view_array = array();
$edit_result = FALSE;
$insertResult = FALSE;
$deleteResult = FALSE;
$action = 'NO_ACTION';
$current_dir = dirname(__FILE__); // gets current directory name
$dateRemovedResult = '';
$image_dir = '/images/pics'; // the directory where images are stored
$image_dir_path = $current_dir . $image_dir; // full path
// ----------------------------------------------------------------------------
// INCLUDE MODEL AND CLASS
if(file_exists($current_dir.'/lib/model.php') &&
	 file_exists($current_dir.'/lib/classes/cupcake_class.php') &&
	 file_exists($current_dir.'/lib/library.php')) {
  include_once $current_dir.'/lib/model.php';
	include_once $current_dir.'/lib/library.php';
	include_once $current_dir.'/lib/classes/cupcake_class.php';
} else {
  $_SESSION['error'] = 'Could not require files.';
  include $current_dir.'/views/home.php';
  exit;
}

// ----------------------------------------------------------------------------
// GET ACTION POST/GET
if(!empty($_POST['action'])) {
	$action = $_POST['action'];
}
if(!empty($_GET['action'])) {
	$action = $_GET['action'];
}

// ----------------------------------------------------------------------------
/* *********************
* CUPCAKE CLASS
************************ */
if ($action == 'updateClass') {
	$cupcake_flavor = checkString($_POST['Cupcake_Flavor']);
	$filling_flavor = checkString($_POST['Filling_Flavor']);
	$decoration 		= checkString($_POST['Decoration']);
	$color 					= checkString($_POST['Color']);

	$myCupcake->setCupcake($cupcake_flavor,$filling_flavor,$decoration,$color);

	// echo $myCupcake->toStringCupcake();

	$_SESSION['title'] = 'Cupcake Options';

	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------
/* *********************
* UPLOAD IMAGES
************************ */
if ($action == 'Upload') {

    // Validate the file type as an image (so you don't get hacked)
    if ((
    			($_FILES["file1"]["type"] == "image/gif")
       || ($_FILES["file1"]["type"] == "image/jpeg")
       || ($_FILES["file1"]["type"] == "image/pjpeg")
       || ($_FILES["file1"]["type"] == "image/png")
       )
       && ($_FILES["file1"]["error"] == 0)) {
    		$description = $_POST['description'];
        // If everything is good, do the actual upload
        $file1 = upload_file('file1');
    } else {
    	// echo 'here in index.'; exit;
        $_SESSION['error'] = "Invalid file type - Must be a jpg, gif or png.";
        include $current_dir.'/views/imageView.php';
        exit;
    }


    // Informs the user of the process outcome
    if (empty($file1)) {
        $file1 = NULL;
        $_SESSION['message'] = 'Sorry the image could not be uploaded.';
    } else {
    	$_SESSION['message'] = 'The image was uploaded successfully.';
    }

    $picture_array = getPictures();
		$_SESSION['picture_array'] = $picture_array;
    include $current_dir.'/views/imageView.php';
    exit;
}
// ----------------------------------------------------------------------------
/* *********************
* DELETES
************************ */
if ($action == 'Delete Cupcake Flavor') {
	$id 		= $_POST['ID'];
	$flavor = $_POST['1'];
	$deleteResult = cupcakeDelete($id);
	if($deleteResult == TRUE) {
		$_SESSION['message'] .= $flavor.' delete success!';
	} elseif ($deleteResult == FALSE) {
		$_SESSION['message'] .= $flavor.' delete success!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Delete Filling Flavor') {
	$id 		= $_POST['ID'];
	$flavor = $_POST['1'];
	$deleteResult = fillingDelete($id);
	if($deleteResult == TRUE) {
		$_SESSION['message'] .= $flavor.' delete success!';
	} elseif ($deleteResult == FALSE) {
		$_SESSION['message'] .= $flavor.' delete failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Delete Decoration') {
	$id 					= $_POST['ID'];
	$decoration 	= $_POST['1'];
	$deleteResult = decorationDelete($id);
	if($deleteResult == TRUE) {
		$_SESSION['message'] .= $decoration.' delete success!';
	} elseif ($deleteResult == FALSE) {
		$_SESSION['message'] .= $decoration.' delete failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Delete Color') {
	$id 		= $_POST['ID'];
	$color  = $_POST['1'];
	$deleteResult = colorDelete($id);
	if($deleteResult == TRUE) {
		$_SESSION['message'] .= $color.' delete success!';
	} elseif ($deleteResult == FALSE) {
		$_SESSION['message'] .= $color.' delete failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Delete Price') {
	$id = $_POST['ID'];
	$deleteResult = priceDelete($id);
	if($deleteResult == TRUE) {
		$_SESSION['message'] .= 'Price delete success!';
	} elseif ($deleteResult == FALSE) {
		$_SESSION['message'] .= 'Price delete failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'deletePic') {
	$id = $_GET['picID'];
	$deleteResult = pictureDelete($id);
	if($deleteResult == TRUE) {
		$_SESSION['message'] .= 'Picture delete success!';
	} elseif ($deleteResult == FALSE) {
		$_SESSION['message'] .= 'Picture delete failed!';
	}
	$picture_array = getPictures();
	$_SESSION['picture_array'] = $picture_array;
	include $current_dir.'/views/imageView.php';
	exit;
}
// ----------------------------------------------------------------------------
/* *********************
* INSERTS
************************ */
if ($action == 'Add Cupcake Flavor') {
	$flavor = $_POST['1'];
	$status = $_POST['Status'];

	$insertResult = cupcakeInsert($flavor,$status);
	if($insertResult == TRUE) {
		$_SESSION['message'] .= $flavor.' addition success!';
	} elseif ($insertResult == FALSE) {
		$_SESSION['message'] .= $flavor.' addition success!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Add Filling Flavor') {
	$flavor = $_POST['1'];
	$status = $_POST['Status'];

	$insertResult = fillingInsert($flavor,$status);
	if($insertResult == TRUE) {
		$_SESSION['message'] .= $flavor.' addition success!';
	} elseif ($insertResult == FALSE) {
		$_SESSION['message'] .= $flavor.' addition failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Add Decoration') {
	$decoration 	= $_POST['1'];
	$extra_charge = $_POST['2'];
	$status 			= $_POST['Status'];

	$insertResult = decorationInsert($decoration,$extra_charge,$status);
	if($insertResult == TRUE) {
		$_SESSION['message'] .= $decoration.' addition success!';
	} elseif ($insertResult == FALSE) {
		$_SESSION['message'] .= $decoration.' addition failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Add Color') {
	$color  = $_POST['1'];
	$status = $_POST['Status'];

	$insertResult = colorInsert($color,$status);
	if($insertResult == TRUE) {
		$_SESSION['message'] .= $color.' addition success!';
	} elseif ($insertResult == FALSE) {
		$_SESSION['message'] .= $color.' addition failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if ($action == 'Add Price') {
	$dozen 	 = $_POST['1'];
	$without = $_POST['2'];
	$with 	 = $_POST['3'];

	$insertResult = priceInsert($dozen,$without,$with);
	if($insertResult == TRUE) {
		$_SESSION['message'] .= 'Price addition success!';
	} elseif ($insertResult == FALSE) {
		$_SESSION['message'] .= 'Price addition failed!';
	}
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
/* *********************
* EDIT
************************ */
if($action == "Edit Cupcake Flavor") {
	$id 		= $_POST['ID'];
	$flavor = $_POST['1'];
	$status = $_POST['Status'];
	$date_removed = $_POST['date_removed'];

	if ($date_removed == "" && $status == 'NOT_ACTIVE') {
		$dateRemovedResult = updateDateRemoved('cupcake','ADD',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} elseif (!empty($date_removed) && $status == 'ACTIVE') {
		$dateRemovedResult = updateDateRemoved('cupcake','NULL',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} // end date_removed check

	$edit_result = editCupcake($id,$flavor,$status);
	if($edit_result == TRUE) {
		$_SESSION['message'] .= 'Update '.$flavor.' success!';
	} else {
		$_SESSION['message'] .= 'Update '.$flavor.' failed.';
	}

	$view_array = getCupcakeFlavors();
	$_SESSION['title'] = 'Cupcake Flavors';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == "Edit Filling Flavor") {
	$id 		= $_POST['ID'];
	$flavor = $_POST['1'];
	$status = $_POST['Status'];
	$date_removed = $_POST['date_removed'];

	if ($date_removed == "" && $status == 'NOT_ACTIVE') {
		$dateRemovedResult = updateDateRemoved('filling','ADD',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} elseif (!empty($date_removed) && $status == 'ACTIVE') {
		$dateRemovedResult = updateDateRemoved('filling','NULL',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} // end date_removed check

	$edit_result = editFilling($id,$flavor,$status);
	if($edit_result == TRUE) {
		$_SESSION['message'] .= 'Update '.$flavor.' success!';
	} else {
		$_SESSION['message'] .= 'Update '.$flavor.' failed.';
	}

	$view_array = getFillingFlavors();
	$_SESSION['title'] = 'Filling Flavors';
	$_SESSION['view_array'] = $view_array;

	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == "Edit Decoration") {
	$id 					= $_POST['ID'];
	$decoration 	= $_POST['1'];
	$extra_charge = $_POST['2'];
	$status 			= $_POST['Status'];
	$date_removed = $_POST['date_removed'];

	if ($date_removed == "" && $status == 'NOT_ACTIVE') {
		$dateRemovedResult = updateDateRemoved('decoration','ADD',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} elseif (!empty($date_removed) && $status == 'ACTIVE') {
		$dateRemovedResult = updateDateRemoved('decoration','NULL',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} // end date_removed check

	$edit_result = editDecorations($id,$decoration,$extra_charge,$status);
	if($edit_result == TRUE) {
		$_SESSION['message'] .= 'Update '.$decoration.' success!';
	} else {
		$_SESSION['message'] .= 'Update '.$decoration.' failed.';
	}

	$view_array = getDecorations();
	$_SESSION['title'] = 'Decorations';
	$_SESSION['view_array'] = $view_array;

	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == "Edit Color") {
	$id 		= $_POST['ID'];
	$color  = $_POST['1'];
	$status = $_POST['Status'];
	$date_removed = $_POST['date_removed'];

	if ($date_removed == "" && $status == 'NOT_ACTIVE') {
		$dateRemovedResult = updateDateRemoved('color','ADD',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} elseif (!empty($date_removed) && $status == 'ACTIVE') {
		$dateRemovedResult = updateDateRemoved('color','NULL',$id);
		if($dateRemovedResult == TRUE) {
			$_SESSION['message'] .= 'Update Date Removed success!<br />';
		} elseif ($dateRemovedResult == FALSE) {
			$_SESSION['message'] .= 'Update Date Removed failed.<br />';
		} // end dateRemovedResult check
	} // end date_removed check

	$edit_result = editColors($id,$color,$status);
	if($edit_result == TRUE) {
		$_SESSION['message'] .= 'Update '.$color.' success!';
	} else {
		$_SESSION['message'] .= 'Update '.$color.' failed.';
	}

	$view_array = getColors();
	$_SESSION['title'] = 'Colors';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == "Edit Price") {
	$id 		 = $_POST['ID'];
	$dozen 	 = $_POST['1'];
	$without = $_POST['2'];
	$with 	 = $_POST['3'];

	$edit_result = editPrices($id,$dozen,$without,$with);
	if($edit_result == TRUE) {
		$_SESSION['message'] .= 'Update Prices success!';
	} else {
		$_SESSION['message'] .= 'Update Prices failed.';
	}
	$view_array = getPrices();
	$_SESSION['title'] = 'Prices';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == "Edit Desc") {
	$id 		 = $_POST['ID'];
	$description 	 = stripcslashes(htmlspecialchars($_POST['description'],ENT_QUOTES));
	$edit_result = pictureEdit($id,$description);
	if($edit_result == TRUE) {
		$_SESSION['message'] .= 'Update Picture description success!';
	} else {
		$_SESSION['message'] .= 'Update Picture description failed.';
	}
	$picture_array = getPictures();
	$_SESSION['picture_array'] = $picture_array;
	include $current_dir.'/views/imageView.php';
	exit;
}
// ----------------------------------------------------------------------------
/* *********************
* NAV LINKS
************************ */
// ----------------------------------------------------------------------------
if($action == 'multi_link') {
	$cupcake_array = getCupcakeFlavors();
	$cupcake_heading_array = $_SESSION['table_heading_array'];

	$color_array = getColors();
	$color_heading_array = $_SESSION['table_heading_array'];

	$filling_array = getFillingFlavors();
	$filling_heading_array = $_SESSION['table_heading_array'];

	$decoration_array = getDecorations();
	$decoration_heading_array = $_SESSION['table_heading_array'];

	$price_array = getPrices();
	$price_heading_array = $_SESSION['table_heading_array'];

	$multi_heading_array = array($cupcake_heading_array,$color_heading_array,$filling_heading_array,$decoration_heading_array,$price_heading_array);
	$multi_array = array($cupcake_array,$color_array,$filling_array,$decoration_array,$price_array);

	$_SESSION['multi_heading_array'] = $multi_heading_array;
	$_SESSION['multi_array'] = $multi_array;
	$_SESSION['title'] = 'Cupcake Options';

	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'cupcake_flavors_link') {
	$view_array = getCupcakeFlavors();
	$_SESSION['title'] = 'Cupcake Flavors';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'filling_flavors_link') {
	$view_array = getFillingFlavors();
	$_SESSION['title'] = 'Filling Flavors';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'decorations_link') {
	$view_array = getDecorations();
	$_SESSION['title'] = 'Decorations';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'colors_link') {
	$view_array = getColors();
	$_SESSION['title'] = 'Colors';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'prices_link') {
	$view_array = getPrices();
	$_SESSION['title'] = 'Prices';
	$_SESSION['view_array'] = $view_array;
	include $current_dir.'/views/cupcake_view.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'image_link') {
	$picture_array = getPictures();
	$_SESSION['picture_array'] = $picture_array;
	include $current_dir.'/views/imageView.php';
	exit;
}
// ----------------------------------------------------------------------------
if($action == 'home') {
	include $current_dir.'/views/home.php';
	exit;
}
// ----------------------------------------------------------------------------
/* *********************
* LOGIN/LOGOUT
************************ */
if ($action == 'login') {
	$userName = $_POST['userName'];
	$password = $_POST['password'];

	$result = login($userName,$password);

	if ($result === 0) {
		$_SESSION['loginStatus'] = TRUE;
	} else {
		$_SESSION['loginStatus'] = FALSE;
	}
}
// ----------------------------------------------------------------------------
if ($action == 'logout') {
	$_SESSION['loginStatus'] = FALSE;
}

include $current_dir.'/views/home.php';

?>
