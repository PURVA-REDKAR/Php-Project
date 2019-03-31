<!DOCTYPE html>
<html>
<head>

<?php

require "FN.class.php";
require "Team.class.php";
require "Validate.class.php";

     FN::session_check();

    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $awaycolor=$homecolor=$league=$mascot=$maxplayers=$name=$picture=$season=$sport= "";
    if (!empty( $_POST )) {


        $teams = new Team();

        if (!empty($_POST["name"]) ){

             $username = $_POST["name"];
             $awaycolor = $_POST["awaycolor"];
             $homecolor = $_POST["homecolor"];
             $mascot = $_POST["mascot"];
             $maxplayers = $_POST["maxplayers"];
             $picture =  $_POST["picture"];
             $league = $_POST["league"];
             $season = $_POST["season"];
             $sport = $_POST["sports"];

              //get all the teams and sanitize the values
            $teams->setAwayColor(VS::Sanitize($awaycolor));
            $teams->setHomeColor(VS::Sanitize($homecolor));
            $teams->setleague($league );
            $teams->setMascot(VS::Sanitize($mascot));
            $teams->setMaxPlayers($maxplayers);
            $teams->setName(VS::Sanitize($username));
            $teams->setPicture(VS::Sanitize($picture));
            $teams->setSeason($season );
            $teams->setSport($sport);

             if($teams->ValidateTeam($username) == 1){

                    if (is_numeric($maxplayers)){
                        $teams->addTeams();
                        $_SESSION["page"] = 'Team.php' ;
                        header("Location: template.php");
                     }
                     else{
                       echo '<div class="error">Please check values entered (Maxnumber should be number)</div>';
                         $maxplayers = "";

                     }

             }
             else{
                      echo '<div class="error">Team with same name  already exists</div>' ;
                      $username="";

             }

         }



     }

?>

</head>
<body>
<div>
       <?php echo FN::formhead();?>
     <th class='cell100 column1'>Add Team</th>
     </tr></thead></table></div>
    <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     <div class='table100-body '><table><tbody>
     <?php echo FN::formrow();?>
    Name: <input type="text" name="name"  REQUIRED><br>
    </td></tr>
    <?php echo FN::formrow();?>
    Away color: <input type="color" name="awaycolor" value="<?php echo $awaycolor;?>"><br>
    </td></tr>
    <?php echo FN::formrow();?>
    Homecolor: <input type="color" name="homecolor" value="<?php echo $homecolor;?>"><br>
    </td></tr>
    <?php echo FN::formrow();?>
    Mascot: <input type="text" name="mascot" value="<?php echo $mascot;?>"><br>
    </td></tr>
    <?php echo FN::formrow();?>
    Max Payers: <input type="text" name="maxplayers" value="<?php echo $maxplayers;?>"><br>
    </td></tr>
    <?php echo FN::formrow();?>
    Picture: <input type="text" name="picture"><br>
    </td></tr>

    <?php
           echo FN::formrow();
             echo"League :";
       if($_SESSION["role"] == 1){
            $value["league"] =   FN::build_drop_down("league","server_league","");
            $value["league"] = $value["league"]."</select>" ;
            echo $value["league"];
        }
        else{
            $team_id = $_SESSION["league"] ;
            $sql = "SELECT name  FROM server_league where id = ?";
            $teams = $db->doQuery($sql,array($team_id),array(PDO::PARAM_INT));
            foreach($teams as $row){
                    $team = $row["name"];

              }
            echo "<input type='text' name='league' value='$team' readonly><br>" ;
        }

    ?>
   </td></tr>

    <?php
             echo FN::formrow();
             echo"Season :";
           $value["season"] =   FN::build_drop_down("season","server_season","","description");
           $value["season"] = $value["season"]."</select>" ;
           echo $value["season"];



    ?>
  </td></tr>

        <?php
        echo FN::formrow();
             echo"Sports:";
        if($_SESSION["role"] == 1){
            $value["sports"] =   FN::build_drop_down("sports","server_sport","");
            $value["sports"] = $value["sports"]."</select>" ;
            echo $value["sports"];
        }
        else{
             $team_id = $_SESSION["league"] ;
            $sql = "SELECT sp.name FROM `server_slseason` as SLS JOIN server_sport as sp ON sp.id = SLS.sport where SLS.league  = ?";
            $sport_ids = $db->doQuery($sql,array($team_id),array(PDO::PARAM_INT));
            $value["sports"] =   FN::build_drop_down("sports","server_sport","");
            $value["sports"] = $value["sports"]."</select>" ;

        }


    ?>
    </td></tr>
      </tbody></table>
    <input type="submit">


</div>
</body>
</html>