
<?php


 require "FN.class.php";

  FN::session_check();


 function formrow(){


           $forms = "<tr class='row100 body'>\n";
           $forms .= "<td class='cell100 column1'>";
           return $forms;
 }

if( isset( $_SESSION["loggedIn"])){


      if(isset($_POST['admins'])){

              $_SESSION["page"] = $_POST['admins'] ;
              header("Location: template.php");

        }

           $forms = FN::formhead();
           $forms .= "<th class='cell100 column1'>Admin</th>\n";
           $forms .= "</tr></thead></table></div>\n";
           $forms .= "<div class='table100-body '><table><tbody>" ;
           $forms .= formrow();
           $forms .= "<form action='' method='POST'>";

        if($_SESSION["role"] <5) {



           $forms .= "<button type='submit' name='admins' value='User.php'>Manage USER</button>";
           $forms .= " </td></tr>\n";

           if($_SESSION["role"] == 1 || $_SESSION["role"] == 3 || $_SESSION["role"] == 4){

                   $forms .=  formrow();
                   $forms .= "<button type='submit' name='admins' value='Player.php'>Manage Players</button>";
                   $forms .= "</td></tr>\n";

                   $forms .=  formrow();
                   $forms .= "<button type='submit' name='admins' value='Position.php'>Manage Position</button>";
                   $forms .= "</td></tr>\n";
           }





           $forms .=  formrow();
           $forms .= "<button type='submit' name='admins' value='Team.php'>Manage Teams</button>";
           $forms .= "</td></tr>\n";

            if($_SESSION["role"] <= 2) {

                 $forms .=  formrow();
                 $forms .= "<button type='submit' name='admins' value='seasons.php'>Manage Season</button>";
                 $forms .= "</td></tr>\n";



                 $forms .=  formrow();
                 $forms .= "<button type='submit' name='admins' value='SLS.php'>Manage Season -League -Season</button>";
                 $forms .= "</td></tr>\n";


                 $forms .=  formrow();
                 $forms .= "<button type='submit' name='admins' value='schedule_page.php'>Manage Schedule</button>";
                 $forms .= "</td></tr>\n";



                 if($_SESSION["role"] == 1){

                   $forms .=  formrow();
                   $forms .= "<button type='submit' name='admins' value='Sports.php'>Manage SPORT</button>";
                   $forms .= "</td></tr>\n";
                  }
           }

        }
                   $forms .= "</form>";

                   echo $forms;

}
else{
 

    header("Location: login.php");

}


?>
