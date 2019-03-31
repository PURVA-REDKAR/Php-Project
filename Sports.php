<?php
require "FN.class.php";
require "Sports.Class.php";
require "Validate.class.php";

       $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

    FN::session_check();
    $sports = new Sports();

     if(!empty( $_GET )){

        if(isset($_GET['add'])){

            $_SESSION["page"] = 'AddSport.php' ;
            header("Location: template.php");

         }

         $name =  $_GET['name'] ;
         $sports->setName($name);
         if(isset($_GET['delete'])){

              $sports->deleteSport($name);
         }

         if(isset($_GET['edit'])){

            $user_name = $name."user";
            $user =  $_GET[$user_name] ;



            if($sports->ValidateSport($user) == 1){
                        $sports->editSports($user);
               }
               else {
                  echo '<div class="error">Sport already exists</div>' ;
               }




         }


    }

    $data = $sports->ViewSports();
    echo FN::build_form_add_del_edit($data);

?>
