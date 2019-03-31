<!DOCTYPE html>
<html>
<head>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

    <title>Sport Management</title>
    <?php
        
       if(!isset($_SESSION)){
           session_start();
       }
       if( !isset( $_SESSION["loggedIn"])){
                //check if not logged in
                header("Location: login.php");
       }

       if(isset($_GET['page'])){
          $route = $_GET['page'] ;
          $_SESSION["page"] = $_GET['page'];

                //unset sessions
                if($_GET['page'] == "logout"){

                     $uname = $_SESSION["name"];

                      require_once "Log.class.php";
                      $log = new Log();
                      $log->lfile('logfile.txt');
                      $log->lwrite($uname,"logged out");

                      unset($_SESSION["loggedIn"]);
                      unset($_SESSION["page"]);
                      unset($_SESSION["role"]);
                      unset($_SESSION["team"]);
                      unset($_SESSION["league"]);
                      unset($_SESSION["name"]);

	                  session_destroy();
                      header("Location: login.php");

               }
       }
       else{  //routing pages
         $route = $_SESSION["page"] ;
       }

    ?>
</head>

<body>
<div class='container-table100'>
   <div class='wrap-table100'>
       <div class='table100 ver1 m-b-110'>
          <div class='table100-head'>
            <table>
                <thead>
                    <tr class='row100 head'>

                         <?php
                            if($_SESSION["role"] != 5){
                                   echo " <th class='cell100 column1'><a href= 'template.php?page=Admin.php' >Admin</a></th>";
                            }
                            ?>

                        <th class='cell100 column1'> <a href= 'template.php?page=Schedule.php'>Schedule</a> </th>
                        <th class='cell100 column1'><a  href= 'template.php?page=Teams.php'>Team</a></th>
                        <th class='cell100 column1'><a  href= 'template.php?page=logout'>Log out</a></th>


</tr></thead></table></div>
</div>
</div>
</div>


<?php include "$route";?>


</body>

</html>