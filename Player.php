<?php
require "FN.class.php";
require "Players.Class.php";
require "Validate.class.php";

    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
        FN::session_check();
           $players = new Players();
         if(!empty( $_GET )){
                 //check if user wants to add results
                if(isset($_GET['add'])){

                $_SESSION["page"] = 'AddPlayer.php' ;
                header("Location: template.php");


           }
                //get all the submitted get variables
                $fn = $_GET["firstname"];
                $user_name =  $fn."firstname" ;
                $user_name= str_replace(' ', '', $user_name);
                $user_edit =  $_GET[$user_name];

                $ln_name =  $fn."lastname";
                $ln_name= str_replace(' ', '', $ln_name);
                $ln_edit = $_GET[$ln_name];
                $ln_ori =  $fn."lastnameori";
                $ln_ori= str_replace(' ', '', $ln_ori);
                $ln = $_GET[$ln_ori];

                $dateofbirth_name = $fn."dateofbirth" ;
                $jerseynumber_name = $fn."jerseynumber" ;
                $jerseynumber_name= str_replace(' ', '', $jerseynumber_name);

                $dateofbirth_name= str_replace(' ', '', $dateofbirth_name);

                $ateam_name =  $fn."team";
                $ateam_name= str_replace(' ', '', $ateam_name);

                $dateofbirth =  $_GET[$dateofbirth_name];

                $jerseynumber =  $_GET[$jerseynumber_name];
                $team =  $_GET[$ateam_name];
                  //set all the submitted get variables  to object and sanitize them
                $players->setFirstName(VS::Sanitize($fn));
                $players->setJerseyNumber(VS::Sanitize($jerseynumber));
                $players->setDateOfBirth(VS::Sanitize($dateofbirth));
                $players->setLastName(VS::Sanitize($ln));
                $players->setTeam($team);

                if(isset($_GET['delete'])){
                    $players->deletePlayers();
                }

               if(isset($_GET['edit'])){
                          
                  if (is_numeric($jerseynumber)){
                         if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dateofbirth)) {
                                  $players->editPlayer($user_edit,$ln_edit);
                             }
                             else{
                                   echo '<div class="error">invalid Date should be yyyy-mm-dd</div>';
                             }


                  }
                  else{
                    echo '<div class="error">Please check values entered (Jersy # should be number)</div>';
                  }
               }


    }

      $data = $players->ViewPlayer();
      echo FN::build_form_add_del_edit($data);


?>