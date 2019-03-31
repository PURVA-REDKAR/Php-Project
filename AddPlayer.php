<!DOCTYPE html>
<html>
<head>
<?php
 require "FN.class.php";
require "Players.Class.php";
require "Validate.class.php";
FN::session_check();

    $players = new Players();
    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

     if (!empty( $_POST )) {
         $fn = $_POST["fname"];
         $ln = $_POST["ln"];
         $dateofbirth = $_POST["dob"];
         $jerseynumber = $_POST["jersy"];
         $team = $_POST["team"];
         // set get values to the player object
          $players->setFirstName(VS::Sanitize($fn));
          $players->setJerseyNumber(VS::Sanitize($jerseynumber));
          $players->setDateOfBirth(VS::Sanitize($dateofbirth));
          $players->setLastName(VS::Sanitize($ln));
          $players->setTeam($team);
           if(isset($fn) && isset($ln) && isset($dateofbirth)){
          // validate if jersy # is numberic
                   if (is_numeric($jerseynumber)){
                  //check if the player exists
                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dateofbirth)) {
                        if($players->ValidatePlayers($fn,$ln)){
                            $players->AddPlayers();
                            $_SESSION["page"] = 'Player.php' ;
                            header("Location: template.php");
                        }

                    else{
                          echo '<div class="error">Player exists</div>';
                        }
                    }
                     else{
                          echo '<div class="error">date format should be yyyy-mm-dd</div>';
                        }
                   }
                   else{
                      echo '<div class="error">Please check values entered (Jersy # should be number)</div>';
                     }
            }
           else{
                    echo '<div class="error">One or more values missing</div>';
               }

      }


?>
</head>
<body>
     <?php echo FN::formhead();?>
       <th class='cell100 column1'>Add Players</th>
         </tr></thead></table></div>
           <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
               <div class='table100-body '><table><tbody>
                <?php echo FN::formrow();?>
              Name: <input type="text" name="fname" required><br>
               </td></tr>
               <?php echo FN::formrow();?>
               Last Name: <input type="text" name="ln" required><br>
               </td></tr>
               <?php echo FN::formrow();?>
              dateofbirth: <input type="text" name="dob" required required pattern="^\d{4}\-(1[012]|0[1-9])"><br>
               </td></tr>
               <?php echo FN::formrow();?>
              jersy #: <input type="text" name="jersy" required><br>
               </td></tr>
                    <?php
                        echo FN::formrow();
                        echo "Team:";
                         $value["team"] =   FN::build_drop_down("team","server_team","");
                         $value["team"] = $value["team"]."</select>" ;
                        echo $value["team"];
                ?>
               <input type="submit">
               </td></tr>
              </tbody>  </table>
     </form>
</body>
</html>