<!DOCTYPE html>
<html>
<head>

<?php

require "FN.class.php";
 require "Schedule.class.php";

     FN::session_check();
    $schedule = new Schedule();


    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $name  = "";
    if (!empty( $_POST )) {

         $schedule = new Schedule();
           //check for no imput
        if (!isset($_POST["awayscore"])  || !isset($_POST["homescore"]) || !isset($_POST["scheduled"]) ) {
                echo '<div class="error">One or more values missing</div>' ;
             }
          else{
              //get all post varabls  and sanitize values
             $awayscore = $_POST["awayscore"];
             $schedule->setAwayScore(VS::Sanitize($awayscore));

             $homescore = $_POST["homescore"];
             $schedule->setHomeScore(VS::Sanitize($homescore));

             $scheduled = $_POST["scheduled"];
             $schedule->setScheduled(VS::Sanitize($scheduled));

             $completed = $_POST["completed"];
             $schedule->setCompleted(VS::Sanitize($completed));

             $season = $_POST["season"];
             $schedule->setSeason($season);

             $sports = $_POST["sports"];
             $schedule->setSport($sports);

             $hometeam = $_POST["hometeam"];
             $schedule->setHomeTeam(VS::Sanitize($hometeam));

             $awayteam = $_POST["awayteam"];
             $schedule->setAwayTeam(VS::Sanitize($awayteam));

             $league = $_POST["league"];
             $schedule->setLeague($league);

              if(is_numeric($_POST["awayscore"]) && is_numeric($_POST["homescore"])){
                  //valdation for duplicate and more validation
                 if($schedule->ValidateSchedule($awayteam,$hometeam) == 1 && $awayteam != $hometeam ){
                          if($completed == 0 || $completed == 1){
                               //pattern match for date
                              if(preg_match("/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/",$scheduled)){
                                 //add the record
                                 $schedule->addSchedule();
                                 $_SESSION["page"] = 'schedule_page.php' ;
                                 header("Location: template.php");
                               }
                               //display errors
                               else{
                                    echo '<div class="error">Schedule date should be  yyyy-mm-dd hh:mm:ss</div>' ;
                               }
                            }
                           else{
                                echo '<div class="error">Completed should be 0 or 1</div>' ;
                           }
                }
                else{
                        echo '<div class="error">This team combination already exists or you have entered same team for away and home</div>' ;
                }
              }
              else{
                   echo '<div class="error">Score should be numeric</div>' ;
             }
           }


    }

?>

<body>
</body>
<div>
       <?php echo FN::formhead();?>
     <th class='cell100 column1'>Add Schedule</th>
     </tr></thead></table></div>
    <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class='table100-body '><table><tbody>

    <?php
        echo FN::formrow();
         echo "season:";
        $value["season"] =   FN::build_drop_down("season","server_season","","description");
        $value["season"] = $value["season"]."</select>" ;
        echo $value["season"];

     ?></td></tr>
     <?php
            echo FN::formrow();
            echo "Sport:";
            $value["sports"] =   FN::build_drop_down("sports","server_sport","");
            $value["sports"] = $value["sports"]."</select>" ;
            echo $value["sports"];

    ?></td></tr>
    <?php echo FN::formrow();?>
    Away score: <input type="text" name="awayscore" required><br>
    </td></tr>

        <?php
             echo FN::formrow();
             echo"Away team:";
            $value["awayteam"] =   FN::build_drop_down("awayteam","server_team","");
            $value["awayteam"] = $value["awayteam"]."</select>" ;
            echo $value["awayteam"];
          ?>
          </td></tr>

     <?php
           echo FN::formrow();
           echo "Home Team:";
            $value["hometeam"] =   FN::build_drop_down("hometeam","server_team","");
            $value["hometeam"] = $value["hometeam"]."</select>" ;
            echo $value["hometeam"];
      ?> </td></tr>
      <?php echo FN::formrow();?>
    Home Score: <input type="text" name="homescore" required><br>
   <?php
            echo FN::formrow();
            echo "League:";
            $value["league"] =   FN::build_drop_down("league","server_league","");
            $value["league"] = $value["league"]."</select>" ;
            echo $value["league"];
    ?></td></tr>
    <?php echo FN::formrow();?>
    Scheduled: <input type="text" name="scheduled" value="1999-09-09 00:00:00" required pattern="^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01]) \d{2}:\d{2}:\d{2}$/"><br>
    </td></tr>
    <?php echo FN::formrow();?>
    Completed: <input type="text" name="completed" required><br>
    </td></tr>
     </tbody></table>
    </div>
    <input type="submit">
     </form>
     </body>
</html>