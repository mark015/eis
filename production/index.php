<?php include 'incl/north.php';?>
        <!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row col-md-12 col-sm-12" style="display: inline-block;" >
    <?php

  // Define an associative array for links and their corresponding files
      $Adminpages = [
          "employee" => "controller/employeeRecords.php",
          "dashboard" => "controller/dashboard.php",
          "years" => "controller/years.php",
      ];
      // Assume $rowUser is already defined and populated correctly
      // echo $rowUser['role']; // Consider commenting this out in production
      // Check if the user role matches and the link exists in the appropriate pages array
      if (($rowUser['role'] === "Admin" || $rowUser['role'] === "User") && array_key_exists($link, $Adminpages)) {
          include $Adminpages[$link]; // Corrected to use $Adminpages
      }  else {
          session_destroy(); // Destroy the session
      }
    ?>
  </div>
  <!-- /top tiles -->
</div>

<?php include 'incl/south.php';?>
