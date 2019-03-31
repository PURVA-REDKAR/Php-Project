<!DOCTYPE html>
<html>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

<head>
<script src='https://www.google.com/recaptcha/api.js'></script>

<?php
require "User.class.php";
require "FN.class.php";
require "Validate.class.php";

 $username = "";
if(!empty( $_GET )){
    if(isset($_GET['gauth'])){
       $username = $_GET['gauth'];

       echo '<div class="error"> hi '.$username.'!!As this is your first time loging in , One more step to complete your registration</div>' ;

    }
}
if(!empty( $_POST )){

  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
    //your site secret key
    $secretKey = '6Lf8IJgUAAAAANQUEpQdCDMO7NN1wW7mCEdFu9MH';
    //get verify response data
    $captcha=$_POST['g-recaptcha-response'];
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        if($responseKeys["success"]) {
              $users = new User();
              $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;
             if (!empty($_POST["username"]) && !empty($_POST["password"])){

                if(!isset($_GET['gauth'])){
                   $username = $_POST["username"];
                }

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
                //set values to object
                $users->setUserName($username);
                $users->setTeam($team);
                $users->setRole($role);
                $users->setLeague($league);
                $users->setPassword($password);
                //validate if user exists
                if($users->ValidateUsers($username) == 1){

                     $users->addUsers();
                     header("Location: login.php");

                 }
                 else{
                   echo '<div class="error">User with same name  already exists</div>' ;
                  }

              }
              else{

                 echo '<div class="error">User name or password empty</div>' ;

             }
              }
              else {
                echo '<div class="error">Capcha not set</div>';
              }

          }
}
?>


</head>
<body>

    <?php
       echo FN::formhead();?>
     <th class='cell100 column1'>Register user</th>
     </tr></thead></table></div>
    <form   method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class='table100-body '><table><tbody>
         <?php echo FN::formrow();?>
    User Name: <input type="text" name="username"  value="<?php echo $username;?>" required><br>
    </td></tr>
     <?php echo FN::formrow();?>
    Password: <input type="password" name="password" required>
    </td></tr>
    <?php


             echo FN::formrow();
           echo "Role :";
             $value["role"] =  FN::build_drop_down("role","server_roles","");
             $value["role"] = $value["role"]."</select>" ;
             echo $value["role"];
    ?>
      </td></tr>
    <?php
            echo FN::formrow();
           echo "Team :";
           $value["team"] =   FN::build_drop_down("team","server_team","");
           $value["team"] = $value["team"]."<option value='NULL'>No Team</option>";
           $value["team"] = $value["team"]."</select>" ;
            echo $value["team"];




    ?>

       </td></tr>
    <?php
         echo FN::formrow();
        echo "League :"  ;
        $value["league"] =   FN::build_drop_down("league","server_league","");
        $value["league"] = $value["league"]."<option value='NULL'>No League</option>";
        $value["league"] = $value["league"]."</select>" ;
        echo $value["league"];
    ?>

    <div class="g-recaptcha" data-sitekey="6Lf8IJgUAAAAANosxv1HIcStYn5iyiRo2GyifZi6"></div>
    <input type="submit" id="register_button" name="submit">
    </td></tr>
</form>
</body>
</html>