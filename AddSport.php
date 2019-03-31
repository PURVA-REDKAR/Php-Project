<!DOCTYPE html>
<html>
<head>
<?php

require "FN.class.php";
 require "Sports.Class.php";
 require "Validate.class.php";

    $sports = new Sports();
    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $name  = "";
    $sports = new Sports();

     if (!empty( $_POST )) {

          if (!empty($_POST["name_sports"]) ){
               $sport_name = $_POST["name_sports"];
               $sports->setName($sport_name);


                //validate for duplicates
                if($sports->ValidateSport($sport_name) == 1){
                          $sports->addSports();
                          //add sports and reloaad sports.php to dispplay results
                          $_SESSION["page"] = 'Sports.php' ;
                       header("Location: template.php");
               }
               else {
                  echo '<div class="error">same SPORT already exists</div>' ;
               }

           }
            else{

                echo '<div class="error">Enter sports</div>
                ';
            }


     }


?>
</head>
<body>
     <?php echo FN::formhead();?>
     <th class='cell100 column1'>Add Sports</th>
     </tr></thead></table></div>

    <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     <div class='table100-body '><table><tbody>
     <tr class='row100 body'> <td class='cell100 column1'>Sports: <input type="text" name="name_sports" required/>
    </td></tr>
      </tbody></table>
    </div>
    <input type="submit">
     </form>
</body>
</html>