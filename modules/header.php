<?php
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Cupcakes By Meiske</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- <link href="lib/css/CupcakesByMeiskeStyle.css" rel="stylesheet" type="text/css" media="screen" /> -->
    <link href="lib/css/newCSS.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script>
     $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
      })
     $('a[data-toggle="tab"]').on('shown', function (e) {
        e.target // activated tab
        e.relatedTarget // previous tab
      })
    </script>
  </head>
  <body>
  <div class="container-fluid">


    <!-- was cupcakeLogo.png -->
    <!-- <img src="images/cupcakeLogo.png" id="logo" > -->

    <div id="header">



      <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="container-fluid">

            <ul class="nav">
              <li><a href="index.php?action=home">Home</a></li>
              <?php if (!empty($_SESSION['loginStatus']) && $_SESSION['loginStatus'] == TRUE) {  ?>
              <li><a href="index.php?action=cupcake_flavors_link">Cupcake</a></li>
              <li><a href="index.php?action=filling_flavors_link">Filling</a></li>
              <li><a href="index.php?action=decorations_link">Decorations</a></li>
              <li><a href="index.php?action=colors_link">Colors</a></li>
              <li><a href="index.php?action=prices_link">Prices</a></li>
              <?php } else {  ?>
              <li><a href="index.php?action=multi_link">Cupcake Options</a></li>
              <?php } ?>
              <li><a href="index.php?action=image_link">Pictures</a></li>
            </ul>

            <ul class="nav pull-right"><li><a class="brand" href="index.php?action=home">Cupcakes By Meiske</a></li></ul>

          </div>
          <!-- end navbar container -->
        </div>
        <!-- end navbar inner -->
      </div>
      <!-- end navbar -->

    </div>
    <!-- end header div -->