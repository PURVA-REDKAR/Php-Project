<!DOCTYPE html>
<html>
<head>

<?php

require "FN.class.php";
 require "Position.class.php";
 require "Validate.class.php";

       FN::session_check(); 
    $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
    $name  = "";
    if (!empty( $_POST )) {

         $position = new Position();
             //check not emplty of name
          if (!empty($_POST["name"])){

             $name = $_POST["name"];
             $position->setName(VS::Sanitize($name));
              //validate position
             if($position->ValidatePosition($name) == 1){
                          $position->addPosition();
                          $_SESSION["page"] = 'Position.php' ;
                          header("Location: template.php");
                }
             else {
                          echo '<div class="error">User with same Position already exists</div>' ;
             }

          }

    }

?>
</head>
<body>
</body>

    <?php echo FN::formhead();?>
     <th class='cell100 column1'>Add Possition</th>
     </tr></thead></table></div>

    <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
         <div class='table100-body '><table><tbody>
     <tr class='row100 body'> <td class='cell100 column1'>
      Name: <input type="text" name="name" required><br>
    </td></tr>
      </tbody></table>
    </div>
    <input type="submit">
     </form>
     </body>
</html>