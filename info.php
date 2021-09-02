 <?php
     include "header.php" ;
     include "sidebar.php" ;
     ?>

<?php
if(isset($_POST['addEmployee'])||isset($_POST['addManager'])){
	$id = $_POST['employeeNumber'];
	$Uname =$_POST['name'];
	$Upass = '';
	$Uemail = $_POST['email'];
	//$Utype=$_POST['type'];

	$name = $_POST['name'];
	$mobile = $_POST['mobile'];
	$employeeNumber = $_POST['employeeNumber'];
	$user_id= $_SESSION['id'];


	$sql = "SELECT * FROM  users WHERE id = '$id' or email='$Uemail'";
	   $re = mysqli_query($comm,$sql);//perform query
	    $sql2 = "SELECT * FROM  Manager WHERE id = '$id' or email='$Uemail'";
	   $re2 = mysqli_query($comm,$sql2);//perform query
	    $sql3 = "SELECT * FROM  employee WHERE id = '$id' or email='$Uemail'";
	   $re3 = mysqli_query($comm,$sql3);//perform query
	  if($re->num_rows !=0 || $re2->num_rows !=0 || $re3->num_rows!=0){
	    $error =true;
	  }
	if( !empty($Uname)){
		/*$sql = "INSERT INTO  users (id,username,password,type,email) values ('$id','$Uname','$Upass','$Utype','$Uemail') ";
		//var_dump($sql);die();
		$re = mysqli_query($comm,$sql);//perform query
		//$id= mysqli_insert_id($comm);*/
		if(isset($_POST['addManager']))
		{
		  if(isset($error))
		  {
		  		$Mmessage ="Please enter  number or Email a non repeated";
		  }
		  else
		   {
			$sql = "INSERT INTO  Manager (id,user_id,name,mobile,email) values ('$id','$user_id','$name','$mobile','$Uemail') ";
			}

		}
		else
		{
		  if(isset($error))
		  {
		  		$Emessage ="Please enter  number or Email a non repeated ";
		  }
		  else
		   {
			$ManagerId=$_POST['managerId'];
			$sql = "INSERT INTO  employee (id,user_id,name,mobile,managerId,email) values ('$id','$user_id','$name','$mobile','$ManagerId','$Uemail') ";
			}
			//die($sql);
		}

		$re = mysqli_query($comm,$sql);//perform query
		if(mysqli_connect_error()){
				die(mysqli_connect_error());
			}
}else {
	$message ="Please Enter  name or id";
}
}
$user_id= $_SESSION['id'];
$sql = "SELECT manager.*,username FROM  manager inner join users on users.id=user_id where user_id='$user_id'";
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$managersInfo=array();
while($rows=mysqli_fetch_assoc($re)){
	$managersInfo[$i]["id"] = $rows['id'];
	$managersInfo[$i]["username"] = $rows['username'];
	$managersInfo[$i]["name"] = $rows['name'];
	$managersInfo[$i]["mobile"] = $rows['mobile'];
	$managersInfo[$i]["type"] = "manager";
	$managersInfo[$i]["email"] = $rows['email'];
	$i++;
}


$sql = "SELECT employee.*,username FROM  employee inner join users  on users.id=user_id where user_id='$user_id'";
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$usersInfo=array();
while($rows=mysqli_fetch_assoc($re)){
	$usersInfo[$i]["id"] = $rows['id'];
	$usersInfo[$i]["username"] = $rows['username'];
	$usersInfo[$i]["name"] = $rows['name'];
	$usersInfo[$i]["mobile"] = $rows['mobile'];
	$usersInfo[$i]["type"] = "employee";
	$usersInfo[$i]["email"] = $rows['email'];
	$i++;
}
?>
  <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover ;background-attachment: fixed;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Data Entry
            <small></small>
          </h1>

        </section>

        <!-- Main content -->
        <section class="content" style="direction: ltr;text-align: left;">
			<div  class="row">
				  <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"> Managers</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">Name</th>
                       <th style="width: 10px">Added by</th>
                      <th style="direction: ltr;text-align: left;">ID</th>
                      <th style="direction: ltr;text-align: left;">Email</th>
                      <th style="direction: ltr;text-align: left;">Job</th>
                       <th style="direction: ltr;text-align: left;">Mobile</th>


                    </tr>

                    <?php foreach($managersInfo as $userInfo):?>
                    <tr>
                      <td><?php echo $userInfo["name"]?></td>
                       <td><?php echo $userInfo["username"]?></td>
                    <td><?php echo $userInfo["id"]?></td>
                       <td><?php echo $userInfo["email"]?></td>
                      <?php if($userInfo["type"]=="manager"):?>
                      <td><span class="label label-success">Manger</span></td>
                  	<?php elseif($userInfo["type"]=="info"):?>
                  	<td><span class="label label-primary">data entry</span></td>
                  	 <?php else :?>
                  	<td><span class="label label-warning">Manger</span></td>
                  	<?php endif?>
                  		 <td><?php echo $userInfo["mobile"]?></td>


                    </tr>
                	<?php endforeach?>

                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
				 <div class="col-md-6">
			      <!-- general form elements -->
			      <div class="box box-primary">
			        <div class="box-header">
			          <h3 class="box-title">Add manager</h3>
			          <?php if(isset($Mmessage)):?>
						<p class="login-box-msg" style="color:red"><?php echo $Mmessage ?></p>
					<?php endif?>
			        </div><!-- /.box-header -->
			        <!-- form start -->
			        <form role="form" method="POST" id="target2">
			          <div class="box-body">
			          	<div class="form-group">
			              <label for="exampleInputEmail1">Name</label>
			              <input type="text" name="name" id="username" class="form-control" id="exampleInputEmail1" placeholder="Enter name">
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">ID</label>
			              <input type="text" name="employeeNumber" id="id" class="form-control" id="exampleInputEmail1" placeholder="enter ID">
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">Email</label>
			              <input type="text" name="email" id="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
			            </div>
			           <!-- <div class="form-group">
			              <label for="exampleInputPassword1">كلمة السر</label>
			              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			            </div>-->
			            <div class="form-group">
			              <label for="exampleInputEmail1">Mobile</label>
			              <input type="text" name="mobile" id="mobile" class="form-control" id="exampleInputEmail1" placeholder="Enter mobile">
			            </div>

			            <div class="form-group">
	                      <input type="hidden" name="type" value="manager">
	                    </div>
			          </div><!-- /.box-body -->

			          <div class="box-footer">
			            <button type="submit" name="addManager" class="btn btn-primary">Submit</button>
			          </div>
			        </form>
			      </div><!-- /.box -->
			    </div><!--/.col (left) -->
			    <!-- right column -->
			</div>
			<div class="row">
				<div class="col-md-6">
					  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Employees</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">Name</th>
                      <th style="direction: ltr;text-align: left;">Added by</th>
                      <th style="direction: ltr;text-align: left;">ID</th>
                      <th style="direction: ltr;text-align: left;">Email</th>
                      <th style="direction: ltr;text-align: left;">Job</th>
                       <th style="direction: ltr;text-align: left;">Mobile</th>


                    </tr>

                    <?php foreach($usersInfo as $userInfo):?>
                    <tr>
                      <td><?php echo $userInfo["name"]?></td>
                      <td><?php echo $userInfo["username"]?></td>
                      <td><?php echo $userInfo["id"]?></td>
                       <td><?php echo $userInfo["email"]?></td>
                      <?php if($userInfo["type"]=="manager"):?>
                      <td><span class="label label-success">manager</span></td>
                  	<?php elseif($userInfo["type"]=="info"):?>
                  	<td><span class="label label-primary">Data entry</span></td>
                  	 <?php else :?>
                  	<td><span class="label label-warning">employee</span></td>
                  	<?php endif?>
                  		 <td><?php echo $userInfo["mobile"]?></td>


                    </tr>
                	<?php endforeach?>

                  </table>
                </div><!-- /.box-body -->
				</div>
			</div>
				<div class="col-md-6">
					 <!-- general form elements -->
			      <div class="box box-primary">
			        <div class="box-header">
			          <h3 class="box-title">Add Employee</h3>
			          <?php if(isset($Emessage)):?>
						<p class="login-box-msg" style="color:red"><?php echo $Emessage ?></p>
					<?php endif?>
			        </div><!-- /.box-header -->
			        <!-- form start -->
			        <form role="form" method="POST" id="target">
			          <div class="box-body">
			          	<div class="form-group">
			              <label for="exampleInputEmail1">Name</label>
			              <input type="text" name="name" id="username2" class="form-control" id="exampleInputEmail1" placeholder="Enter name">
			            </div>
			              <div class="form-group">
			              <label for="exampleInputEmail1">ID</label>
			              <input type="text" id="id2" name="employeeNumber" class="form-control" id="exampleInputEmail1" placeholder="enter ID">
			            </div>
			            <div class="form-group">
			              <label for="exampleInputEmail1">Email</label>
			              <input type="text" name="email" id="email2" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
			            </div>

			           <!-- <div class="form-group">
			              <label for="exampleInputEmail1">اسم الستخدم</label>
			              <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter username">
			            </div>-->
			           <!--  <div class="form-group">
			              <label for="exampleInputPassword1">كلمة السر</label>
			              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			            </div> -->
			            <div class="form-group">
			              <label for="exampleInputEmail1">Mobile</label>
			              <input type="text" name="mobile" id="mobile2" class="form-control" id="exampleInputEmail1" placeholder="Enter mobile">
			            </div>

			            <div class="form-group">
			              <label for="exampleInputEmail1">Manager</label>
			              <select name="managerId">
			              	 <?php foreach($managersInfo as $mInfo):?>
			              	 	<option value="<?php echo $mInfo['id']?>"><?php echo $mInfo['name']?></option>
			              	 <?php endforeach?>
			              </select>
			            </div>
			            <div class="form-group">
	                    </div>
			          </div><!-- /.box-body -->

			          <div class="box-footer">
			            <button type="submit" name="addEmployee" class="btn btn-primary">Submit</button>
			          </div>
			        </form>
			      </div><!-- /.box -->
				</div>
			</div>
		</section>
	</div>

<?php
include "footer.php" ;
?>
<script type="text/javascript">
	   $( "#target" ).submit(function( event ) {
              var error = false;

              var input=$("#username2");
              var re = /^[a-zA-Z- ]+$/;
              var is_string=re.test(input.val());
             // alert(is_string);
              if(!is_string){
                error =true;
                alert("name must contain only letter");
              }


             if($("#id2").val().length!=10)
             {
              error = true;
              alert("ID must be 10 digits long");
             }
              re = /^[0-9]+$/;
              var is_number=re.test($("#id2").val());
             // alert(is_string);
              if(!is_number){
                 error =true;
                alert("ID must contain numbers only");
              }

              is_number=re.test($("#mobile2").val());
             // alert(is_string);
              if(!is_number){
                 error =true;
                alert("The mobile must contain numbers only");
              }

              re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
              var is_email=re.test($("#email2").val());
              if(!is_email){
                error =true;
                alert("The email field must contain an Email");
              }
              if(error)
                event.preventDefault();
            });

	   $( "#target2" ).submit(function( event ) {
	   //	alert("fff");
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
                alert("The email field must contain an Emailا");
              }
              if(error)
                event.preventDefault();
            });
    </script>
</script>
