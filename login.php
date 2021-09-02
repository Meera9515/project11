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
		header("location:index.php");// i need it in next every page
	}
	if(isset($_POST['login'])){
		//get data
	$Upass = $_POST['id'];
	$Uname = $_POST['username'];
  $Utype=$_POST['type'];
	$Uremem = isset($_POST['remember'])?$_POST['remember']:FALSE;
	if(!empty($Uname) && !empty($Upass)){
		if($Utype=="info")
		  $sql = "SELECT * FROM  users WHERE username = '$Uname' ";
    else if($Utype=="manager")
       $sql = "SELECT *,name as username FROM  manager WHERE name = '$Uname' ";
    else if($Utype=="employee")
       $sql = "SELECT *,name as username FROM  employee WHERE name = '$Uname' ";

		$re = mysqli_query($comm,$sql);//perform query
		//var_dump($re);die();
		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}
	while($rows=mysqli_fetch_assoc($re)){

		$DB_pass = $rows['id'];
		if($DB_pass == $Upass){
			$login = TRUE ;
		}else {
			$login = FALSE ;
		}

		if($login == TRUE){
			if(isset($Uremem) && $Uremem==TRUE){
				//first arg ay name youwant to put it
				setcookie('Username' ,$Uname , time()+3600 );
			}
				//if he didn't put remember me
      $_SESSION['id'] = $rows['id'] ;
			$_SESSION['Username'] = $rows['username'] ;
			$_SESSION['type'] = $Utype ;
			//var_dump("enter");
      if($Utype == "info")
			   header("location:info.php");
       else if($Utype == "manager")
          header("location:manager.php");
        else if($Utype == "employee")
          header("location:employee.php");
			exit();
		}else {
			$message ="Please Enter valid username or password";
		}
	}//end while
}else {
	$message ="Please Enter valid username or password";
}
}
	 ?>
   <body class="login-page" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;">

    <div class="login-box">
      <div class="login-logo">
        <a href="index2.html"><b></b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
		<?php if(isset($message)):?>
		<p class="login-box-msg" style="color:red"><?php echo $message ?></p>

		<?php endif?>
        <form action="" method="post" id="target">
          <div class="form-group has-feedback">
            <input type="text" name="username" name="username" class="form-control" placeholder="Name"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="id" id="id" class="form-control" placeholder="ID"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
           <div class="form-group has-feedback">
              <select name="type" class="form-control">
                 <option value="info">Data Entry</option>
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>

              </select>
            </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input name="remember" type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>



       <a href="restore.php">I forgot my password</a><br>
        <a href="register.php">Register</a>
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
              var re = /^[a-zA-Z]+$/;
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
              if(error)
                event.preventDefault();
            });

      });
    </script>
  </body>
</html>
