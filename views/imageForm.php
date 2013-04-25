<?php
/* ************************************************************************
* AUTHOR:  Craig W. Christensen
* DATE:    December 23, 2012
* DESCRIPTION: View for uploading images for CupcakesByMeiske.cwcraigo.com.
************************************************************************ */
session_start();

?>
<?php require_once 'modules/header.php'; ?>

<div id="content" >

  <h2>Upload Image Form</h2>
  <?php
  if (isset($message)) {
   echo "<p>$message</p>";
   if (isset($file1)) {
    echo "<p><img src='$file1' width='400'></p>";
   }
  } else {
   ?>
   <form action="." method="POST" enctype="multipart/form-data">
    <label>File 1:</label>
    <input type="file" name="file1"><br>
    <input id="upload_button" type="submit" value="Upload">
    <input type="hidden" name="action" value="upload">
   </form>
  <?php } ?>
 <?php require_once 'modules/footer.php'; ?>
