<?php


require "FN.class.php";
require "Season.class.php";
require "Validate.class.php";

    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
        FN::session_check();
           $season = new Season();
    if(!empty($_GET)){
              //check if user wants to add results
             if(isset($_GET['add'])){

                $_SESSION["page"] = 'AddSeason.php' ;
                 header("Location: template.php");
             }
               //get all the submitted get variables
            $year =  $_GET['year'] ;
            $user_year = $year."user";
            $desc_name = $year."descriptionori";
            $desc =   $_GET[$desc_name] ;
            $year_edit =  $_GET[$user_year] ;
            $desc_edit =  $year."description";
            $desc_e =   $_GET[$desc_edit] ;
            //set all the submitted get variables  to object and sanitize them    
            $season->setYear(VS::Sanitize($year));
            $season->setDescription(VS::Sanitize($desc));

            if(isset($_GET['delete'])){

                 $season->deleteSeason();

            }

           if(isset($_GET['edit'])){

             if($season->ValidateSeason($year,$desc) == 1){
                 if(!empty($year) && !empty($desc)){
                    if(is_numeric($year)){
                       $season->editSeason($year_edit,$desc_e);
                    }
                    else{
                         echo '<div class="error">Year should be numeric</div>' ;
                    }
                  }
                  else{
                         echo '<div class="error">blank values</div>' ;
                    }
               }
               else {
                  echo '<div class="error">same season and year already exists</div>' ;
               }

          }



    }

      $data = $season->ViewSeason();
   echo FN::build_form_add_del_edit($data);



?>
