<!DOCTYPE html>
<html>
<head>

<?php

require "FN.class.php";
require "SLS.class.php";


     FN::session_check();
     $sls = new SLS();

    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

              if (!empty( $_POST )) {

                 $sls = new SLS();

                  $season = $_POST["season"];
                  $sls->setSeason($season);

                  $sports = $_POST["sports"];
                  $sls->setSports($sports);

                  $league = $_POST["league"];
                  $sls->setLeague($league);
                  //validate for duplicates
                  if($sls->ValidateSLS($season,$sports,$league) == 1){
                         $sls->addSLS();
                        $_SESSION["page"] = 'SLS.php' ;
                        header("Location: template.php");
                 }
                  else{
                   echo '<div class="error">User with same SLS   already exists</div>' ;
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

    <?php
             echo FN::formrow();
            echo "League:";
            $value["league"] =   FN::build_drop_down("league","server_league","");
            $value["league"] = $value["league"]."</select>" ;
            echo $value["league"];
    ?></td></tr>
    </tbody></table>
    </div>
    <input type="submit">
</form>

<div>
</body>
</html>