<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title> Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <?php
  include "confing.php" ;
  //var_dump($comm);
  if(logdein() == TRUE){
    header("location:home.php");// i need it in next every page
  }
  $checkedEmail=false;
  if(isset($_POST['checkEmail'])){
    //get data
  $Uemail = $_POST['email'];
  $Utype=$_POST["type"];

  if(!empty($Uemail)){

   if($Utype=="info")
      $sql = "SELECT * FROM  users WHERE email = '$Uemail' ";
    else if($Utype=="manager")
       $sql = "SELECT *,name as username FROM  manager WHERE email = '$Uemail' ";
    else if($Utype=="employee")
       $sql = "SELECT *,name as username FROM  employee WHERE email = '$Uemail' ";

    $re = mysqli_query($comm,$sql);//perform query

    if(mysqli_connect_error()){
              die(mysqli_connect_error());
            }
  if($re->num_rows == 1){

     while($rows=mysqli_fetch_assoc($re)){
       $userId = $rows['id'];
    }
    $checkedEmail=true;
  }
  else
    $message ="Please Enter valid email";

}else {
  $message ="Please Enter valid email";
}
}
else if(isset($_POST['savePassword']))
{
  $id = $_POST['password'];
  $Uemail = $_POST['email'];
  $Utype = $_POST["type"];
  $oldId=$_POST["oldId"];
  $sql = "SELECT * FROM  users WHERE id = '$id'";
   $re = mysqli_query($comm,$sql);//perform query
    $sql2 = "SELECT * FROM  Manager WHERE id = '$id'";
   $re2 = mysqli_query($comm,$sql2);//perform query
    $sql3 = "SELECT * FROM  employee WHERE id = '$id'";
   $re3 = mysqli_query($comm,$sql3);//perform query
  if($re->num_rows !=0 || $re2->num_rows !=0 || $re3->num_rows!=0){
     $message ="Please enter  ID a non repeated";

  }

    else if(!empty($id)){
       if($Utype=="manager")
      {
         $sql = "update  manager set id='$id' WHERE email = '$Uemail' ";
         $sql2 = "update  project set manager_id='$id' WHERE manager_id = '$oldId' ";
         $sql3 ="update employee set managerId = '$id' where managerId='$oldId'";
        // var_dump($sql3);die();
      }
      else if($Utype=="employee")
      {
         $sql = "update  employee set id='$id' WHERE email = '$Uemail' ";
         $sql2 ="update tasks set employeeId='$id' where employeeId='$oldId'";
      }
      else
      {
         $sql = "Update  users set id='$id' WHERE email = '$Uemail' ";
        $sql2 = "update  manager set user_id='$id' WHERE user_id = '$oldId' ";
         $sql3 ="update employee set user_id ='$id' where user_id='$oldId'";
      }
    // die($sql);
      $re = mysqli_query($comm,$sql);//perform query
      if(isset($sql2))
         $re = mysqli_query($comm,$sql2);//perform query
       if(isset($sql3))
         $re = mysqli_query($comm,$sql3);//perform query
      if(mysqli_connect_error()){
      die(mysqli_connect_error());
    }
    header("location:login.php");
  }
}
   ?>
  <body class="login-page" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover ;background-attachment: fixed;">
    <div class="login-box">
      <div class="login-logo">

      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"> Restore</p>
    <?php if(isset($message)):?>
    <p class="login-box-msg" style="color:red"><?php echo $message ?></p>

    <?php endif?>

    <?php if(!$checkedEmail):?>
        <form action="" method="post" id="target">
          <div class="form-group has-feedback">
            <input type="text" name="email" id="email" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
            <div class="form-group has-feedback">
              <select name="type" class="form-control">
                 <option value="info">Data Entry</option>
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>

              </select>
            </div>
          <div class="row">

            <div class="col-xs-4">
              <button type="submit" name="checkEmail" class="btn btn-primary btn-block btn-flat">check email</button>
            </div><!-- /.col -->
          </div>
        </form>
    <?php else :?>


       <form action="" method="post" id="target2">
           <input type="hidden" name="email" class="form-control" value="<?php echo $Uemail?>"/>
            <input type="hidden" name="type" class="form-control" value="<?php echo $Utype?>"/>
            <input type="hidden" name="oldId" class="form-control" value="<?php echo $userId?>"/>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="id" class="form-control" placeholder="New ID"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">

            <div class="col-xs-4">
              <button type="submit" name="savePassword" class="btn btn-primary btn-block btn-flat">update</button>
            </div><!-- /.col -->
          </div>
        </form>
    <?php endif?>



       <a href="login.php">login</a><br>
       <!--  <a href="register.html" class="text-center">Register a new membership</a> -->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrbootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
         $( "#target" ).submit(function( event ) {
              var error = false;
              re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
              var is_email=re.test($("#email").val());
              if(!is_email){
                error =true;
                alert("The email field must contain an email");
              }
              if(error)
                event.preventDefault();
            });

          $( "#target2" ).submit(function( event ) {
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
                alert("ID must contain only numbers");
              }
              if(error)
                event.preventDefault();
            });

      });
    </script>
  </body>
</html>
