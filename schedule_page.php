
<?php

   require "FN.class.php";
   require "Schedule.class.php";


      FN::session_check();
   $schedule = new Schedule();

        if(!empty( $_GET )){

           //check if user wants to add results
           if(isset($_GET['add'])){

                 $_SESSION["page"] = 'AddSchedule.php' ;
                 header("Location: template.php");
               
           }
           //get all the post variables
        $sport = $_GET["sport"];
        $user_name =  $sport."user";
        $sport_edit =  $_GET[$user_name];


        $description_name =  $sport."description";
        $description_edit = $_GET[$description_name];
        $description_ori =  $sport."descriptionori";
        $description = $_GET[$description_ori];


        $league_name =  $sport."league";
        $league_ori =  $sport."leagueori";
        $league_ori= str_replace(' ', '', $league_ori);
        $league_name= str_replace(' ', '', $league_name);
        $league_edit = $_GET[$league_name];
        $league = $_GET[$league_ori ];

           //set all the submitted get variables  to object and sanitize them
        $ateam_name =  $sport."awayteam";
        $ateam_ori =  $sport."awayteamori";
        $ateam_ori= str_replace(' ', '', $ateam_ori);
        $ateam_name= str_replace(' ', '', $ateam_name);
        $ateam_edit = $_GET[$ateam_name];
        $ateam = $_GET[$ateam_ori ];

        $hteam_name =  $sport."hometeam";
        $hteam_ori =  $sport."hometeamori";
        $hteam_ori= str_replace(' ', '', $hteam_ori);
        $hteam_name= str_replace(' ', '', $hteam_name);
        $hteam_edit = $_GET[$hteam_name];
        $hteam = $_GET[$hteam_ori];

        $hscore_name =  $sport."homescore" ;
        $hscore = $_GET[$hscore_name];
        $ascore_name =  $sport."awayscore" ;
        $ascore = $_GET[$ascore_name];

        $scheduled_name =  $sport."scheduled" ;
        $comp_name =  $sport."completed" ;

        $scheduled = $_GET[$scheduled_name];
        $comp = $_GET[$comp_name];

         //set all the submitted get variables  to object and sanitize them
        $schedule->setAwayScore(VS::Sanitize($ascore));
        $schedule->setAwayTeam(VS::Sanitize($ateam));
        $schedule->setCompleted(VS::Sanitize($comp));
        $schedule->setHomeScore(VS::Sanitize($hscore));
        $schedule->setHomeTeam(VS::Sanitize($hteam));
        $schedule->setLeague($league);
        $schedule->setScheduled(VS::Sanitize($scheduled)) ;
        $schedule->setSeason($description);
        $schedule->setSport($sport);

     //delete
   if(isset($_GET['delete'])){



         $schedule->deleteSchedule();


   }
   if(isset($_GET['edit'])){

             //validate and edit


               if($schedule->ValidateSchedule($ateam_edit,$hteam_edit) == 1  && $ateam_edit !=  $hteam_edit){

                       if(is_numeric($ascore) && is_numeric($hscore)){

                            if($comp == 0 || $comp == 1 || !empty($scheduled)){

                               if(preg_match("/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/",$scheduled)){

                                  $schedule->editSchedule($sport_edit,$description_edit,$league_edit,$ateam_edit,$hteam_edit);
                                }
                                else{
                                    echo '<div class="error">Schedule date should be  yyyy-mm-dd hh:mm:ss</div>' ;
                               }

                            }
                            else{
                               echo '<div class="error">Completed should be 0 or 1 or schedule missing</div>' ;
                            }
                        }
                        else{
                               echo '<div class="error">Score should be numeric</div>' ;
                      }
                }

                else{
                        echo '<div class="error">Same team   cannot pay against each other</div>' ;
                }



   }


    }

    $data =$schedule->ViewSchedule();

    echo FN::build_form_add_del_edit($data);

?>
