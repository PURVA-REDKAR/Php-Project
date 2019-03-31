<!DOCTYPE html>
<html>
<head>

<?php

require "FN.class.php";
require "User.class.php";
require "Validate.class.php";


     $username = $password = $role = $league = $team = "";
     if (!empty( $_GET )) {
       $username = $_GET["gauth"];
       $flag =1;
     }


    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

    if (!empty( $_POST )) {


        $users = new User();

        if (!empty($_POST["username"]) && !empty($_POST["password"])){
             //add post vairable to users object and santize the results
             $username = $_POST["username"];
             $password = $_POST["password"];
             $role = $_POST["role"];
             $team = $_POST["team"];
             if($team == "NULL"){

                 $team = "";
              }

             $league = $_POST["league"];
            if($league == "NULL"){
                $league = "";
             }

            $users->setUserName(VS::Sanitize($username));
            $users->setTeam($team);
            $users->setRole($role);
            $users->setLeague($league);
            $users->setPassword($password);

             if($users->ValidateUsers($username) == 1){
                     //validate for emplty results and reload the page
                     $users->addUsers();
                     $_SESSION["page"] = 'User.php' ;
                     header("Location: template.php");

            }
            else{
                   echo '<div class="error">User with same name  already exists</div>' ;
             }
         }
         else{

                 echo '<div class="error">User name or password empty</div>' ;

             }

     }

?>

</head>
<body>

       <?php echo FN::formhead();?>
     <th class='cell100 column1'>Add uSER</th>
     </tr></thead></table></div>
    <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class='table100-body '><table><tbody>
         <?php echo FN::formrow();?>
    User Name: <input type="text" name="username"   required><br>
    </td></tr>
     <?php echo FN::formrow();?>
    Password: <input type="password" name="password" required><br>
    </td></tr>

    <?php
             echo FN::formrow();
           echo "Role :";
          if($_SESSION["role"] == 1){
             $value["role"] =  FN::build_drop_down("role","server_roles","");
             $value["role"] = $value["role"]."</select>" ;
             echo $value["role"];
          }
          else{
                $value["role"] = "<select name='role'>";
                if(isset($flag)){
                    $role_id =  5;
                }
                else{
                $role_id = $_SESSION["role"] ;
                }
                $sql = "SELECT name  FROM server_roles where id >= ?";
                $db_array = $db->doQuery($sql,array($role_id),array(PDO::PARAM_INT));
                $select = FN::drop_down($db_array,"", "role");
                 foreach($select as $row){

                      $value["role"] = $value["role"].$row;

                }
                $value["role"] = $value["role"]."</select>" ;
                echo $value["role"];
          }
    ?>
    </td></tr>

    <?php

        echo FN::formrow();
           echo "Team :";
        if($_SESSION["role"] == 1 || isset($flag)|| $_SESSION["role"] == 2)  {
           $value["team"] =   FN::build_drop_down("team","server_team","");
           $value["team"] = $value["team"]."<option value='NULL'>No Team</option>";
           $value["team"] = $value["team"]."</select>" ;
            echo $value["team"];
        }
        else{

            $team_id = $_SESSION["team"] ;
            $sql = "SELECT name  FROM server_team where id = ? ";
            $teams = $db->doQuery($sql,array($team_id),array(PDO::PARAM_INT));
            foreach($teams as $row){
                    $team = $row["name"];

              }
            echo "<input type='text' name='team' value='$team' readonly><br>" ;
        }

    ?>
    </td></tr>

    <?php


       if($_SESSION["role"] == 1){
           echo FN::formrow();
        echo "League :"  ;
        $value["league"] =   FN::build_drop_down("league","server_league","");
        $value["league"] = $value["league"]."<option value='NULL'>No League</option>";
        $value["league"] = $value["league"]."</select>" ;
        echo $value["league"];
        }
        
    ?>
   </td></tr>
      </tbody></table>
    </div>
    <input type="submit">
     </form>
     </body>
</html>