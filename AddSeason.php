<!DOCTYPE html>
<html>
<head>
<?php


require "FN.class.php";
require "Season.class.php";
require "Validate.class.php";
FN::session_check();

     $season = new Season();
     $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
     if (!empty( $_POST )) {

          // check if the  year is not empty
          if (!empty($_POST["year"]) && !empty($_POST["description"])){
               $year = $_POST["year"];
               $description = $_POST["description"];
               $season->setYear(VS::Sanitize($year));
               $season->setDescription(VS::Sanitize($description));
                //validate for repeated entry
               if($season->ValidateSeason($year,$description) == 1){
                     //add seasons and reload season,php to display
                     $season->AddSeason();
                     $_SESSION["page"] = 'seasons.php' ;
                    header("Location: template.php");
               }
               else { //echo errors
                  echo '<div class="error">User with same season and year already exists</div>' ;
               }

           }
            else{

                  echo '<div class="error">Values missing</div>
                ';

            }


     }


?>
</head>
<body>
     <?php echo FN::formhead();?>
       <th class='cell100 column1'>Add Season</th>
         </tr></thead></table></div>
           <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
               <div class='table100-body '><table><tbody>
                <?php echo FN::formrow();?>
              Year: <input type="text" name="year" required pattern="^[-+]?\d*$"><br>
               </td></tr>
               <?php echo FN::formrow();?>
               Description: <input type="text" name="description" required><br>

               <input type="submit">
               </td></tr> 
              </tbody>  </table>
     </form>
</body>
</html>