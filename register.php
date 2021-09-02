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
  <?php include "confing.php" ;
  //var_dump($comm);
  if(logdein() == TRUE){
    header("location:home.php");// i need it in next every page
  }
  if(isset($_POST['register'])){
    //get data
  $id =  $_POST['id'];
   $Uemail = $_POST['email'];

    $sql = "SELECT * FROM  users WHERE id = '$id' or email='$Uemail'";
     $re = mysqli_query($comm,$sql);//perform query
      $sql2 = "SELECT * FROM  Manager WHERE id = '$id' or email='$Uemail'";
     $re2 = mysqli_query($comm,$sql2);//perform query
      $sql3 = "SELECT * FROM  employee WHERE id = '$id' or email='$Uemail'";
     $re3 = mysqli_query($comm,$sql3);//perform query
    if($re->num_rows !=0 || $re2->num_rows !=0 || $re3->num_rows!=0){
       $message ="Please enter  number or Email a non repeated";
    }
  else
   {
        $Uname = $_POST['username'];
      

        $Utype = "info";
        if(!empty($Uname)){
          $sql = "INSERT INTO  users (id,username,password,type,email) values ('$id','$Uname','$Upass','$Utype','$Uemail') ";
          $re = mysqli_query($comm,$sql);//perform query
          if(mysqli_connect_error()){
          die(mysqli_connect_error());
        }
         $_SESSION['id'] =$id;
        $_SESSION['Username'] = $Uname ;
        $_SESSION['type'] = $Utype;
        header("location:info.php");
   }

}
}
   ?>
   <body class="login-page" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;">

    <div class="login-box">
      <div class="login-logo">
      <!--  <a href="index2.html"><b>Admin</b></a> -->
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
    <?php if(isset($message)):?>
    <p class="login-box-msg" style="color:red"><?php echo $message ?></p>

    <?php endif?>
        <form action="" method="post" id="target">
           <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="user name"/>

          </div>
           <div class="form-group has-feedback">
            <input type="text" name="id" id="id" class="form-control" placeholder="ID"/>

          </div>
          <div class="form-group has-feedback">
            <input type="text" name="email" id ="email" class="form-control" placeholder="Email"/>

          </div>


          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>



       <a href="restore.php">I forgot my password</a><br>
       <a href="login.php">Login</a><br>
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

              var input=$("#username");
              var re = /^[a-zA-Z- ]+$/;
              var is_string=re.test(input.val());
             // alert(is_string);
              if(!is_string){
                error =true;
                alert("Name must contain only letters");
              }


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

              re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
              var is_email=re.test($("#email").val());
              if(!is_email){
                error =true;
                alert("The email field must contain an email");
              }
              if(error)
                event.preventDefault();
            });
      });
    </script>
  </body>
</html>
