
<?php

require "FN.class.php";
require "SLS.class.php";

     FN::session_check();
   // $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $sls = new SLS();

    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

    if(!empty($_GET)){
             //check if user wants to add results
             if(isset($_GET['add'])){

            $_SESSION["page"] = 'AddSLS.php' ;
              header("Location: template.php");

             }
                //get all the submitted get variables
               $league =  $_GET['league'] ;
               $league_name1 = $league."league";
               $league_name1 = str_replace(' ', '', $league_name1);
               $league_name = $_GET[$league_name1];


               $sport_name =  $league."sport";
               $sport_name = str_replace(' ', '', $sport_name);
               $sport = $_GET[$sport_name];

               $seasons =  $league."season";
               $seasons = str_replace(' ', '', $seasons);
               $season = $_GET[$seasons];


                 $sport_ori =  $league."sportori";
                 $sport_ori = str_replace(' ', '', $sport_ori);
                 $sport_o = $_GET[$sport_ori];

                 $season_ori =  $league."seasonori";
                 $season_ori = str_replace(' ', '', $season_ori);
                 $season_o = $_GET[$season_ori];
                 //set all the submitted get variables  to object and sanitize them
                 $sls->setLeague($league);
                 $sls->setSports($sport_o);
                 $sls->setSeason($season_o);

          if(isset($_GET['delete'])){

                    
                 $sls->deleteSLS();

            }
            if(isset($_GET['edit'])){


                 //validate and update
                 if($sls->ValidateSLS($season,$sport,$league_name) == 1){
                      $sls->editSLS($sport,$season,$league_name);

                }
                else{
                   echo '<div class="error">User with same SLS   already exists</div>' ;
                }


           }

    }

    $data =  $sls->ViewSLS();
    echo FN::build_form_add_del_edit($data);


?>
