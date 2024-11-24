 </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       <?php include 'incl/footer.php';?>
        <!-- /footer content -->
      </div>
    </div>
	<?php include 'incl/script.php';?>
  <?php
    if($link == "employee"){
      include 'script/employee.php';
    }else if($link == "years"){
      include 'script/years.php ';
    }else if($link == "dashboard"){
      include 'script/dashboard.php ';
    }
  ?>
  </body>
</html>