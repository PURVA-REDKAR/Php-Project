

<?php

    require "FN.class.php";
    require "Position.class.php";
    require "Validate.class.php";

    FN::session_check();
    $position = new Position();
    if(!empty( $_GET )){


              //check if user wants to add results
             if(isset($_GET['add'])){

                 $_SESSION["page"] = 'AddPosition.php' ;
                 header("Location: template.php");


              }
               //get all the post variables
             $name =  $_GET["name"];
             $name1 = str_replace(' ', '', $name);
             $pos_name =$name1."name";
             $pos_edit =  $_GET[$pos_name];

            $position->setName(VS::Sanitize($name));

              //delete
            if(isset($_GET['delete'])){
                  $position->deletePosition();
            }
             //validate and update
           if(isset($_GET['edit'])){
                  if($position->ValidatePosition($pos_edit) == 1){
                        $position->editPosition($pos_edit);
                  }
                    else {
                           echo '<div class="error">User with same Position already exists</div>' ;
                    }
            }


    }


    $data = $position->ViewPosition();

    echo FN::build_form_add_del_edit($data);


?>