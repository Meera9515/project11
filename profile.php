<!DOCTYPE html>
<html>

  <head>


    <?php
     include "confing.php" ;
     $message="";
  //var_dump($comm);
  if(isset($_POST["updateInfo"]))
  {
    //var_dump("oo");die();
       $id = $_POST["id"];
       $oldId = $_POST["oldId"];
       $email = $_POST["email"];
      $mobile = $_POST["mobile"];
      $Uname = $_SESSION["Username"];
      $Oid = $_SESSION["id"];
          $sql = "SELECT * FROM  users WHERE id = '$id'and id!='$Oid' or email= '$email'";
         $re = mysqli_query($comm,$sql);//perform query
          $sql2 = "SELECT * FROM  Manager WHERE id = '$id' and id!='$Oid' or email= '$email' ";
         $re2 = mysqli_query($comm,$sql2);//perform query
          $sql3 = "SELECT * FROM  employee WHERE id = '$id' and id!='$Oid' or email= '$email' ";
         $re3 = mysqli_query($comm,$sql3);//perform query
        if($re->num_rows !=0 || $re2->num_rows !=0 || $re3->num_rows!=0){
        //  var_dump($Oid."  ".$re->num_rows."  ".$re2->num_rows." ".$re3->num_rows);
          $error =true;
        }
        if(!isset($error))
        {
            if($_SESSION["type"]=="manager")
            {
               $sql = "update  manager set email='$email',mobile='$mobile',id='$id' WHERE name = '$Uname' ";
               $sql2 = "update  project set manager_id='$id' WHERE manager_id = '$oldId' ";
               $sql3 ="update employee set managerId = '$id' where managerId='$oldId'";
              // var_dump($sql3);die();
            }
            else
            {
               $sql = "update  employee set email='$email',mobile='$mobile',id='$id' WHERE name = '$Uname' ";
               $sql2 ="update tasks set employeeId='$id' where employeeId='$oldId'";
            }
           // var_dump($sql);die();
            $re = mysqli_query($comm,$sql);//perform query
            if(isset($sql2))
               $re = mysqli_query($comm,$sql2);//perform query
             if(isset($sql3))
               $re = mysqli_query($comm,$sql3);//perform query
            if(mysqli_connect_error()){
                die(mysqli_connect_error());
              }
              $_SESSION["id"]=$id;
        }
}
  if(isset($_GET['username'])){
    //get data
    $Uname = $_GET['username'];
    if($_SESSION["type"]=="manager")
    {
       $sql = "SELECT * FROM  manager WHERE name = '$Uname' ";
    }
    else
    {
       $sql = "SELECT * from employee WHERE name = '$Uname' ";
    }

    $re = mysqli_query($comm,$sql);//perform query
   // die($sql);
    if(mysqli_connect_error())
      {
        die(mysqli_connect_error());
      }
  while($rows=mysqli_fetch_assoc($re)){
        //if he didn't put remember me
      $email = $rows['email'];;
      $mobile = $rows['mobile'];
       $userId = $rows['id'];
      //var_dump("enter");

  }//end while
}
   ?>

    <meta charset="UTF-8">
    <title>Profile</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="lockscreen" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover ;background-attachment: fixed;">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
            <b>Task Tracking System</b>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"><?php echo $_SESSION['Username'];?>
      <?php if(isset($error)) echo "Please enter  number or Email a non repeated";?></div>

      <!-- START LOCK SCREEN ITEM -->
       <form class="lockscreen-credentials" id="target" method="POST">
        <label for="email">Email:</label>
       <input name="email" id="email" class="form-control" value="<?php echo $email?>" placeholder="email" />
       <br>
       <label for="email">mobile:</label>
        <input name="mobile" id="mobile" class="form-control" value="<?php echo $mobile?>" placeholder="mobile" />
          <label for="id">id:</label>
        <input name="id" id="id" class="form-control" value="<?php echo $userId?>" placeholder="mobile" />
         <input type="hidden" name="oldId" class="form-control" value="<?php echo $userId?>" />
        <br>
        <input type="submit" name="updateInfo">
    </div><!-- /.center -->
    <br>
    <a href="index.php">back to home</a>

    <!-- jQuery 2.1.3 -->
    <script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $( "#target" ).submit(function( event ) {
              var error = false;


             if($("#id").val().length!=10)
             {
              error = true;
              alert("ID must be 10 digits long");
             }
              re = /^[0-9]+$/;
              var is_number=re.test($("#id").val());
             // alert(is_string);
              if(!is_number){
                 error =true;
                alert("ID must contain numbers only");
              }

              is_number=re.test($("#mobile").val());
             // alert(is_string);
              if(!is_number){
                 error =true;
                alert("The mobile must contain numbers only");
              }

              re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
              var is_email=re.test($("#email").val());
              if(!is_email){
                error =true;
                alert("The email field must contain an Email");
              }
              if(error)
                event.preventDefault();
            });

    </script>
  </body>

</html>
