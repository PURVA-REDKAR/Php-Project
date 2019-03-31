<!DOCTYPE html>
<html>
<head>

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
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php

require_once('settings.php');
require "FN.class.php";
require_once "User.class.php";


        if(!isset($_SESSION)){
           session_start();
       }


        $uname = $password = "";


         if ( !empty( $_POST ) ) {



               //check if capcha is set
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
                     if($responseKeys["success"]) {




                           //username and password not empty
                         if (!empty($_POST["username"]) && !empty($_POST["password"])){



                                $users = new User();
                                $uname =  $_POST["username"];
                                $password =  $_POST["password"];
                                require "Log.class.php";
                                $log = new Log();
                                $log->lfile('logfile.txt');
                                $log->lwrite($uname,"logged in");

                                 $db = new DB(DB_HOST, DB_USER, DB_PASS, DB_NAME) ;

                                  $sql =  "SELECT *
                                  FROM server_user
                                  WHERE username = ?"  ;

                                  $data = $db->doQuery($sql,array($uname),array(PDO::PARAM_STR));
                                  //check if user exists
                                 if(!empty($data)){


                                       foreach( $data as $rows){

                                             $dbpass = substr( $rows['password'], 0, 60 );
                                             $role = $rows['role'];
                                        }

                                    //check for password
                                  if (password_verify($password, $dbpass)) {

                                        $_SESSION["name"] =  $uname ;
                                        $_SESSION["loggedIn"] = "true" ;
                                        $_SESSION["role"] = $rows['role'] ;
                                        $_SESSION["team"] = $rows['team'] ;
                                        $_SESSION["league"] = $rows['league'] ;
                                         $_SESSION["page"] = 'firstpage.php' ;
                                       header("Location: template.php");
                                       echo '<div class="error">Password is valid!</div>';
                                   } else {

                                          echo '<div class="error">Invalid password</div>';
                                   }


                                 }
                                 else{

                                    echo '<div class="error">user doesnot exists</div>';
                                 }
                            }
                            else{

                                    echo '<div class="error">Please make sure you have entered both user name and password</div>';
                            }
                   }
                   else{

                            echo '<div class="error">Problem with Capcha</div>';
                   }

              }
              else{

                       echo '<div class="error">Capcha not set</div>';
              }

        }



?>


</head>
<body>
        <div class="limiter">
             <div class="container-table100">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

			<div class="wrap-table100">
				<div class="table100 ver1 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
								    	<th class="cell100 column1">Login</th>
								</tr>
							</thead>
						</table>
					</div>
                    <div class="table100-body">
					<table>
					 <tbody>
					  <tr class="row100 body">
                         <td class="cell100 column1"><label> User Name: <input type="text" name="username" required></label></td>
                          <td class="cell100 column1"><label> Password: <input type="password" name="password" required></label></td>
                          <td class="cell100 column1"><label><div class="g-recaptcha" data-sitekey="6Lf8IJgUAAAAANosxv1HIcStYn5iyiRo2GyifZi6"></div> </label></td>
      				  </tr>
					  </tbody>
					 </table>
				</div>
			</div>
          </div>


        <input type="submit" name="submit">
    </form>


    <a href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>">
        <p style="color:red ;padding:3px;background-color: powderblue;" >Login with Google
         </p></a>
         <a href="register.php">
             <p style="color:red ;padding:3px;background-color: powderblue;">Register user
             </p></a>
    </div>
      </div>

</body>
</html>