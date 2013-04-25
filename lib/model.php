<?php

/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 17, 2012
* DESCRIPTION: Functions to access cupcakedb to insert, update, select.
************************************************************************ */

if(file_exists('lib/DBconn.php')) {
  require_once 'lib/DBconn.php';
} else {
  $_SESSION['error'] = 'ERROR!!!! Could not require DBconn.php';
  include $current_dir.'/views/cupcake_view.php';
  exit;
}

date_default_timezone_set('America/Los_Angeles');

// ----------------------------------------------------------------------
// CUPCAKE TABLE
// ----------------------------------------------------------------------

/* *********************
* getCupcakeFlavors()
************************ */
function getCupcakeFlavors() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $sql = "SELECT cupcake_id,cupcake_flavor
            FROM cupcake WHERE active_flag = 'ACTIVE'";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
      $stmt->execute();
      $stmt->bind_result($cupcake_id,$cupcake_flavor);
      $cupcake = array();
      $cupcake_array = array();
      while($stmt->fetch()) {
        // $cupcake[0]       = $cupcake_id;
        $cupcake[0]       = $cupcake_flavor;
        $cupcake_array[]  = $cupcake;
      }//end while
      $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array = array();
    // $table_heading_array[0] = 'ID';
    $table_heading_array[0] = 'Cupcake Flavor';

  } else {

    $sql = "SELECT * FROM cupcake";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
    $stmt->execute();
    $stmt->bind_result($cupcake_id,$cupcake_flavor,$active_flag
                  ,$date_removed,$last_update_date);
    $cupcake = array();
    $cupcake_array = array();
    while($stmt->fetch()) {
      $cupcake[0]        = $cupcake_id;
      $cupcake[1]        = $cupcake_flavor;
      $cupcake[2]        = $active_flag;
      $cupcake[3]        = date('F d, Y', strtotime($date_removed));
      $cupcake[4]        = date('F d, Y h:mA', strtotime($last_update_date));
      $cupcake_array[]  = $cupcake;
    }//end while
    $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0] = 'ID';
    $table_heading_array[1] = 'Cupcake Flavor';
    $table_heading_array[2] = 'Status';
    $table_heading_array[3] = 'Date Removed';
    $table_heading_array[4] = 'Last Update Date';

  }

  $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($cupcake_array)) {
    return $cupcake_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getCupcakeFlavors

/* *********************
* editCupcake()
************************ */
function editCupcake($id,$flavor,$status) {
  global $myConn, $db;

  $sql = "UPDATE cupcake
            SET cupcake_flavor = ?, active_flag = ?
            WHERE cupcake_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ssi',$flavor,$status,$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  }
  else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end editCupcake

/* *********************
* cupcakeInsert()
************************ */
function cupcakeInsert($flavor,$status) {
  global $myConn, $db;
  if ($status == 'ACTIVE') {
    $sql = "INSERT INTO cupcake (cupcake_flavor,active_flag) VALUES (?,?)";
  } elseif ($status == 'NOT_ACTIVE') {
    $sql = "INSERT INTO cupcake (cupcake_flavor,active_flag,date_removed) VALUES (?,?,NOW())";
  }
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ss',$flavor,$status);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end cupcakeInsert

/* *********************
* cupcakeDelete()
************************ */
function cupcakeDelete($id) {
  global $myConn, $db;
  $sql = "DELETE FROM cupcake WHERE cupcake_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end cupcakeDelete

// ----------------------------------------------------------------------
// FILLING TABLE
// ----------------------------------------------------------------------

/* *********************
* getFillingFlavors()
************************ */
function getFillingFlavors() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $sql = "SELECT filling_id,filling_flavor
            FROM filling WHERE active_flag = 'ACTIVE'";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
      $stmt->execute();
      $stmt->bind_result($filling_id,$filling_flavor);
      $filling = array();
      $filling_array = array();
      while($stmt->fetch()) {
        // $filling[0]        = $filling_id;
        $filling[0]    = $filling_flavor;
        $filling_array[] = $filling;
      }//end while
      $stmt->close();
    }
    else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array = array();
    // $table_heading_array[0] = 'ID';
    $table_heading_array[0] = 'Filling Flavor';

  } else {

    $sql = "SELECT * FROM filling";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($filling_id,$filling_flavor,$active_flag
                          ,$date_removed,$last_update_date);
       $filling = array();
       $filling_array = array();
       while($stmt->fetch()) {
        $filling[0]        = $filling_id;
        $filling[1]        = $filling_flavor;
        $filling[2]        = $active_flag;
        $filling[3]        = $date_removed;
        $filling[4]        = $last_update_date;
        $filling_array[]  = $filling;
       }//end while
       $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0] = 'ID';
    $table_heading_array[1] = 'Filling Flavor';
    $table_heading_array[2] = 'Status';
    $table_heading_array[3] = 'Date Removed';
    $table_heading_array[4] = 'Last Update Date';

  }

  $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($filling_array)) {
    return $filling_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getFillingFlavors

/* *********************
* editFilling()
************************ */
function editFilling($id,$flavor,$status) {
  global $myConn, $db;

  $sql = "UPDATE filling
            SET filling_flavor = ?, active_flag = ?
            WHERE filling_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ssi',$flavor,$status,$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  }
  else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end editFilling

/* *********************
* fillingInsert()
************************ */
function fillingInsert($flavor,$status) {
  global $myConn, $db;
  if ($status == 'ACTIVE') {
    $sql = "INSERT INTO filling (filling_flavor,active_flag) VALUES (?,?)";
  } elseif ($status == 'NOT_ACTIVE') {
    $sql = "INSERT INTO filling (filling_flavor,active_flag,date_removed) VALUES (?,?,NOW())";
  }
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ss',$flavor,$status);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end fillingInsert

/* *********************
* fillingDelete()
************************ */
function fillingDelete($id) {
  global $myConn, $db;
  $sql = "DELETE FROM filling WHERE filling_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end fillingDelete

// ----------------------------------------------------------------------
// DECORATION TABLE
// ----------------------------------------------------------------------

/* *********************
* getDecorations()
************************ */
function getDecorations() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $sql = "SELECT decoration_id,decoration,extra_charge
            FROM decoration WHERE active_flag = 'ACTIVE'";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($decoration_id,$decoration,$extra_charge);
       $decorationA = array();
       $decoration_array = array();
       while($stmt->fetch()) {
        // $decorationA[0]      = $decoration_id;
        $decorationA[0]      = $decoration;
        $decorationA[1]      = $extra_charge;
        $decoration_array[]  = $decorationA;
       }//end while
       $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array = array();
    // $table_heading_array[0] = 'ID';
    $table_heading_array[0] = 'Decoration';
    $table_heading_array[1] = 'Extra Charge';

  } else {
    $sql = "SELECT * FROM decoration";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($decoration_id,$decoration,$extra_charge
                          ,$active_flag,$date_removed,$last_update_date);
       $decorationA = array();
       $decoration_array = array();
       while($stmt->fetch()) {
        $decorationA[0]      = $decoration_id;
        $decorationA[1]      = $decoration;
        $decorationA[2]      = $extra_charge;
        $decorationA[3]      = $active_flag;
        $decorationA[4]      = $date_removed;
        $decorationA[5]      = $last_update_date;
        $decoration_array[]  = $decorationA;
       }//end while

       $stmt->close();

    }
    else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0] = 'ID';
    $table_heading_array[1] = 'Decoration';
    $table_heading_array[2] = 'Extra Charge';
    $table_heading_array[3] = 'Status';
    $table_heading_array[4] = 'Date Removed';
    $table_heading_array[5] = 'Last Update Date';
  }

  $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($decoration_array)) {
    return $decoration_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getDecorations

/* *********************
* editDecorations()
************************ */
function editDecorations($id,$decoration,$extra_charge,$status) {
  global $myConn, $db;

  $sql = "UPDATE decoration
            SET decoration = ?, extra_charge = ?, active_flag = ?
            WHERE decoration_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('sisi',$decoration,$extra_charge,$status,$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  }
  else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end editDecorations

/* *********************
* decorationInsert()
************************ */
function decorationInsert($decoration,$extra_charge,$status) {
  global $myConn, $db;
  if ($status == 'ACTIVE') {
    $sql = "INSERT INTO decoration (decoration,extra_charge,active_flag) VALUES (?,?,?)";
  } elseif ($status == 'NOT_ACTIVE') {
    $sql = "INSERT INTO decoration (decoration,extra_charge,active_flag,date_removed) VALUES (?,?,?,NOW())";
  }
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('sis',$decoration,$extra_charge,$status);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end decorationInsert

/* *********************
* decorationDelete()
************************ */
function decorationDelete($id) {
  global $myConn, $db;
  $sql = "DELETE FROM decoration WHERE decoration_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end decorationDelete

// ----------------------------------------------------------------------
// COLOR TABLE
// ----------------------------------------------------------------------

/* *********************
* getColors()
************************ */
function getColors() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $sql = "SELECT c.color_id,c.color
            FROM color c WHERE c.active_flag = 'ACTIVE'";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($color_id,$color);
       $colorA = array();
       $color_array = array();
       while($stmt->fetch()) {
        // $colorA[0]      = $color_id;
        $colorA[0]     = $color;
        $color_array[] = $colorA;
       }//end while
       $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array = array();
    // $table_heading_array[0] = 'ID';
    $table_heading_array[0] = 'Color';

  } else {
    $sql = "SELECT * FROM color";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($color_id,$color,$active_flag,$date_removed
                          ,$last_update_date);
       $colorA = array();
       $color_array = array();
       while($stmt->fetch()) {
        $colorA[0]       = $color_id;
        $colorA[1]       = $color;
        $colorA[2]       = $active_flag;
        $colorA[3]       = $date_removed;
        $colorA[4]       = $last_update_date;
        $color_array[]   = $colorA;
       }//end while
       $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0] = 'ID';
    $table_heading_array[1] = 'Color';
    $table_heading_array[2] = 'Status';
    $table_heading_array[3] = 'Date Removed';
    $table_heading_array[4] = 'Last Update Date';
  }

  $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($color_array)) {
    return $color_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getColors

/* *********************
* editColors()
************************ */
function editColors($id,$color,$status) {
  global $myConn, $db;

  $sql = "UPDATE color c
            SET c.color = ?, c.active_flag = ?
            WHERE c.color_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ssi',$color,$status,$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  }
  else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end editColors

/* *********************
* colorInsert()
************************ */
function colorInsert($color,$status) {
  global $myConn, $db;
  if ($status == 'ACTIVE') {
    $sql = "INSERT INTO color (color,active_flag) VALUES (?,?)";
  } elseif ($status == 'NOT_ACTIVE') {
    $sql = "INSERT INTO color (color,active_flag,date_removed) VALUES (?,?,NOW())";
  }
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ss',$color,$status);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end colorInsert

/* *********************
* colorDelete()
************************ */
function colorDelete($id) {
  global $myConn, $db;
  $sql = "DELETE FROM color WHERE color_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end colorDelete

// ----------------------------------------------------------------------
// PRICE TABLE
// ----------------------------------------------------------------------

/* *********************
* getPrices()
************************ */
function getPrices() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $sql = "SELECT price_id,quantity,with_out_filling,with_filling
            FROM price";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($price_id,$quantity,$with_out_filling,$with_filling);
       $price = array();
       $price_array = array();
       while($stmt->fetch()) {
        // $price[0]      = $price_id;
        $price[0]      = $quantity;
        $price[1]      = '$'.$with_out_filling;
        $price[2]      = '$'.$with_filling;
        $price_array[] = $price;
       }//end while
       $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array = array();
    // $table_heading_array[0] = 'ID';
    $table_heading_array[0] = 'Dozen';
    $table_heading_array[1] = 'Without Filling';
    $table_heading_array[2] = 'With Filling';

  } else {

    $sql = "SELECT * FROM price";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
       $stmt->execute();
       $stmt->bind_result($price_id,$quantity,$with_out_filling,$with_filling,$last_update_date);
       $price = array();
       $price_array = array();
       while($stmt->fetch()) {
        $price[0]        = $price_id;
        $price[1]        = $quantity;
        $price[2]        = '$'.$with_out_filling;
        $price[3]        = '$'.$with_filling;
        $price[4]        = $last_update_date;
        $price_array[]   = $price;
       }//end while
       $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0] = 'ID';
    $table_heading_array[1] = 'Dozen';
    $table_heading_array[2] = 'Without Filling';
    $table_heading_array[3] = 'With Filling';
    $table_heading_array[4] = 'Last Update Date';

  }

  $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($price_array)) {
    return $price_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getPrices

/* *********************
* editPrices()
************************ */
function editPrices($id,$dozen,$without,$with) {
  global $myConn, $db;

  if (substr($without, 0, 1) == '$') {
    $without = substr($without, 1);
  }
  if (substr($with, 0, 1) == '$') {
    $with = substr($with, 1);
  }

  $sql = "UPDATE price
            SET quantity = ?, with_out_filling = ?, with_filling = ?
            WHERE price_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('iiii',$dozen,$without,$with,$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  }
  else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end editPrices

/* *********************
* priceInsert()
************************ */
function priceInsert($dozen,$without,$with) {
  global $myConn, $db;

  if (substr($without, 0, 1) == '$') {
    $without = substr($without, 1);
  }
  if (substr($with, 0, 1) == '$') {
    $with = substr($with, 1);
  }

  $sql = "INSERT INTO price (quantity,with_out_filling,with_filling) VALUES (?,?,?)";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('iii',$dozen,$without,$with);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end priceInsert

/* *********************
* priceDelete()
************************ */
function priceDelete($id) {
  global $myConn, $db;
  $sql = "DELETE FROM price WHERE price_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end priceDelete

// ----------------------------------------------------------------------
// CLIENT TABLE
// ----------------------------------------------------------------------

/* *********************
* getClients()
************************ */
function getClients() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $_SESSION['error'] = "Sorry. Please login to access this information.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } else {
    $sql = "SELECT * FROM client";
  }
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
     $stmt->execute();
     $stmt->bind_result($client_id,$first_name,$middle_name,$last_name
                        ,$email,$phone,$creation_date,$last_update_date);
     $client = array();
     $client_array = array();
     while($stmt->fetch()) {
      $client[0]       = $client_id;
      $client[1]       = $first_name;
      $client[2]       = $middle_name;
      $client[3]       = $last_name;
      $client[4]       = $email;
      $client[5]       = $phone;
      $client[6]       = $creation_date;
      $client[7]       = $last_update_date;
      $client_array[]  = $client;
     }//end while
     $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0] = 'ID';
    $table_heading_array[1] = 'First Name';
    $table_heading_array[2] = 'Middle Name';
    $table_heading_array[3] = 'Last Name';
    $table_heading_array[4] = 'Email';
    $table_heading_array[5] = 'Phone Number';
    $table_heading_array[6] = 'Creation Date';
    $table_heading_array[7] = 'Last Update Date';

    $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($client_array)) {
    return $client_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getClients

// ----------------------------------------------------------------------
// CUPCAKE_ORDER TABLE
// ----------------------------------------------------------------------

/* *********************
* getCupcakeOrders()
************************ */
function getCupcakeOrders() {
  global $myConn, $db;

  if (empty($_SESSION['loginStatus']) || $_SESSION['loginStatus'] == FALSE) {
    $_SESSION['error'] = "Sorry. Please login to access this information.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } else {
    $sql = "SELECT * FROM cupcake_order";
  }
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
     $stmt->execute();
     $stmt->bind_result($order_id,$client_id,$cupcake_id,$filling_id
                        ,$cupcake_color,$frosting_color,$decoration_id
                        ,$price_id,$order_status,$creation_date,$last_update_date);
     $cupcake_order = array();
     $cupcake_order_array = array();
     while($stmt->fetch()) {
      $cupcake_order[0]        = $order_id;
      $cupcake_order[1]        = $client_id;
      $cupcake_order[2]        = $cupcake_id;
      $cupcake_order[3]        = $filling_id;
      $cupcake_order[4]        = $cupcake_color;
      $cupcake_order[5]        = $frosting_color;
      $cupcake_order[6]        = $decoration_id;
      $cupcake_order[7]        = $price_id;
      $cupcake_order[8]        = $order_status;
      $cupcake_order[9]        = $creation_date;
      $cupcake_order[10]       = $last_update_date;
      $cupcake_order_array[]   = $cupcake_order;
     }//end while
     $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

    $table_heading_array   = array();
    $table_heading_array[0]  = 'ID';
    $table_heading_array[1]  = 'Client ID';
    $table_heading_array[2]  = 'Cupcake ID';
    $table_heading_array[3]  = 'Filling ID';
    $table_heading_array[4]  = 'Cupcake Color';
    $table_heading_array[5]  = 'Frosting Color';
    $table_heading_array[6]  = 'Decoration ID';
    $table_heading_array[7]  = 'Price ID';
    $table_heading_array[8]  = 'Status';
    $table_heading_array[9]  = 'Creation Date';
    $table_heading_array[10] = 'Last Update Date';

    $_SESSION['table_heading_array'] = $table_heading_array;

  if(!empty($cupcake_order_array)) {
    return $cupcake_order_array;
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." array is empty.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  }
} //end getCupcakeOrders

// ----------------------------------------------------------------------
// PICTURE TABLE
// ----------------------------------------------------------------------

/* *********************
* getPictures()
************************ */
function getPictures() {
  global $myConn, $db;

    $sql = "SELECT * FROM picture";
    $stmt = $myConn->prepare($sql);
    if ($stmt) {
     $stmt->execute();
     $stmt->bind_result($picture_id,$path,$thumbnail,$description,$creation_date,$last_update_date);
     $picture = array();
     $picture_array = array();
     while($stmt->fetch()) {
      $picture['picture_id']        = $picture_id;
      $picture['path']              = $path;
      $picture['thumbnail']         = $thumbnail;
      $picture['description']       = $description;
      $picture['creation_date']     = $creation_date;
      $picture['last_update_date']  = $last_update_date;
      $picture_array[]   = $picture;
     }//end while
     $stmt->close();
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
      include $current_dir.'/views/imageView.php';
      exit;
    } //end prepared stmt

  if(!empty($picture_array)) {
    return $picture_array;
  } else {
    $_SESSION['error'] = "No Pictures Available.";
    return;
  }
} //end getPictures

/* *********************
* pictureInsert()
************************ */
function pictureInsert($path,$thumbnail,$description) {
  global $myConn, $db;

  $sql = "INSERT INTO picture (path,thumbnail,description,creation_date) VALUES (?,?,?,NOW())";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('sss',$path,$thumbnail,$description);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/imageView.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end pictureInsert

/* *********************
* pictureDelete()
************************ */
function pictureDelete($id) {
  global $myConn, $db;
  $sql = "DELETE FROM picture WHERE picture_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end pictureDelete

/* *********************
* pictureEdit()
************************ */
function pictureEdit($id,$description) {
  global $myConn, $db;
  $sql = "UPDATE picture SET description = ? WHERE picture_id = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('si',$description,$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/imageView.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end pictureEdit

// ----------------------------------------------------------------------
// OTHERS
// ----------------------------------------------------------------------

/* *********************
* login()
************************ */
function login($userName,$password) {
  global $myConn, $db;

  $sql = "SELECT system_user_group_id
          FROM system_user
          WHERE system_user_name = ?
          AND system_user_password = ?";
  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('ss',$userName,$password);
    $stmt->bind_result($system_user_group_id);
    $stmt->execute();
    if ($stmt->fetch()) {
      $system_user_group_id = $system_user_group_id;
    }
    $stmt->close();
  }
  else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/home.php';
    exit;
  } //end prepared stmt

  return $system_user_group_id;
} //end login

/* *********************
* updateDateRemoved()
************************ */
function updateDateRemoved($table_name, $action, $id) {
  global $myConn, $db;

  if ($table_name == 'cupcake') {
    if ($action == 'NULL') {
      $sql = "UPDATE cupcake
                SET date_removed = NULL
                WHERE cupcake_id = ?";
    } elseif ($action == 'ADD') {
      $sql = "UPDATE cupcake
                SET date_removed = NOW()
                WHERE cupcake_id = ?";
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." action is not valid.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } // end action check
  } elseif ($table_name == 'filling') {
    if ($action == 'NULL') {
      $sql = "UPDATE filling
                SET date_removed = NULL
                WHERE filling_id = ?";
    } elseif ($action == 'ADD') {
      $sql = "UPDATE filling
                SET date_removed = NOW()
                WHERE filling_id = ?";
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." action is not valid.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } // end action check
  } elseif ($table_name == 'decoration') {
    if ($action == 'NULL') {
      $sql = "UPDATE decoration
                SET date_removed = NULL
                WHERE decoration_id = ?";
    } elseif ($action == 'ADD') {
      $sql = "UPDATE decoration
                SET date_removed = NOW()
                WHERE decoration_id = ?";
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." action is not valid.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } // end action check
  } elseif ($table_name == 'color') {
    if ($action == 'NULL') {
      $sql = "UPDATE color
                SET date_removed = NULL
                WHERE color_id = ?";
    } elseif ($action == 'ADD') {
      $sql = "UPDATE color
                SET date_removed = NOW()
                WHERE color_id = ?";
    } else {
      $_SESSION['error'] = __FILE__." ".__FUNCTION__." action is not valid.";
      include $current_dir.'/views/cupcake_view.php';
      exit;
    } // end action check
  } // end table_name check

  $stmt = $myConn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $rowschanged = $stmt->affected_rows;
    $stmt->close();
  } else {
    $_SESSION['error'] = __FILE__." ".__FUNCTION__." stmt did not prepare.";
    include $current_dir.'/views/cupcake_view.php';
    exit;
  } //end prepared stmt

  if ($rowschanged == 1) {
    return TRUE;
  } else {
    return FALSE;
  }
} //end updateDateRemoved



?>