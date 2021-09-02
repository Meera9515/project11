 <?php
     include "header.php" ;
     include "sidebar.php" ;
     ?>

<?php
if(isset($_GET['assign'])){
	$taskid = $_GET['assign'];


	if(!empty($taskid)){
		$sql = "UPDATE  tasks set type=2  where id='$taskid' ";
		$re = mysqli_query($comm,$sql);//perform query

		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}
	header("location:employee.php");
}else {
	$message ="Please Enter  task name or employee";
}
}
else if(isset($_POST["finish"]))
{
	$taskid = $_POST['id'];


	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
	$uploadOk = 1;
	//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$fileName =basename( $_FILES["fileUpload"]["name"]);
	// Check if image file is a actual image or fake image

		 if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
	        //echo "The file ". basename( $_FILES["fileUpload"]["name"]). " has been uploaded.";
	    }
	    if(!empty($taskid)){
			$sql = "UPDATE  tasks set type=0,file='$fileName',end=current_date()  where id='$taskid' ";
			$re = mysqli_query($comm,$sql);//perform query

			if(mysqli_connect_error()){
			die(mysqli_connect_error());
		}
	}
	                     //header("location:employee.php");
}



$uID=$_SESSION['id'];
$sql = "SELECT *,tasks.id as task_id FROM  tasks inner join employee on employee.id=employeeId where type=1 And employee.id=$uID";
//var_dump($sql);
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$tasksInfo=array();
while($rows=mysqli_fetch_assoc($re)){
	$tasksInfo[$i]["id"] = $rows['task_id'];
	$tasksInfo[$i]["taskname"] = $rows['taskName'];
	$tasksInfo[$i]["name"] = $rows['name'];
	$tasksInfo[$i]["mobile"] = $rows['mobile'];
	$tasksInfo[$i]["start"] = $rows['start'];
	$tasksInfo[$i]["notes"] = $rows['notes'];
	$i++;
}


 $sql = "SELECT * FROM  employee  WHERE employee.id=$uID";
    $re = mysqli_query($comm,$sql);//perform query

    if(mysqli_connect_error())
      {
        die(mysqli_connect_error());
      }
  while($rows=mysqli_fetch_assoc($re)){
        //if he didn't put remember me
     $id = $rows['id'];;
      $email = $rows['email'];;
       $name = $rows['name'];;
      $mobile = $rows['mobile'];
      $rate = $rows['rate'];
    /*  $employeeId = $rows['employeeId'];
       $userId = $rows['userId'];*/
      //var_dump("enter");

  }//end while
?>
  <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;background-attachment: fixed;">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Employee
            <small></small>
          </h1>

        </section>

        <!-- Main content -->
    <section class="content" style="direction: ltr;text-align: left;">
			<div  class="row">
          <div class="col-md-4 pull-left">
             <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Employee information</h3>
                </div><!-- /.box-header -->
                  <div class="box-body" class="">
                    <label>Name:</label>&nbsp;<?=$name?><br><br>
                    <label>ID:</label>&nbsp;<?=$id?><br><br>
                    <label>Email:</label>&nbsp;<?=$email?><br><br>
                    <label>mobile:</label>&nbsp;<?=$mobile?><br><br>
                    <label>The Evaluate :</label>&nbsp;<?=$rate?>%<br><br>
                  </div>
            </div>
          </div>
				  <div class="col-md-8 pull-left">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Task</h3>
                </div><!-- /.box-header -->
                <div class="box-body" class="">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">Task</th>
                      <th style="direction: ltr;text-align: left;">Employee</th>

                       <th style="direction: ltr;text-align: left;">Mobile</th>
                        <th style="direction: ltr;text-align: left;">Start Date</th>
                         <th style="direction: ltr;text-align: left;">Notes</th>
                   <!--   <th style="width: 40px">طلب اسناد</th>-->
                      <th style="width: 40px">Ending</th>
                    </tr>

                    <?php foreach($tasksInfo as $taskInfo):?>
                    <tr>
                      <td><?php echo $taskInfo["taskname"]?></td>
                      <td><?php echo $taskInfo["name"]?></td>
                  		 <td><?php echo $taskInfo["mobile"]?></td>
                  		  <td><?php echo $taskInfo["start"]?></td>
                  		   <td><?php echo $taskInfo["notes"]?></td>
                     <!-- <td>

                       <?php
                        $today = new DateTime('now');
                        $date = new DateTime( $taskInfo["start"]);
                        if($today>=$date):?>
                      	<a href="employee.php?assign=<?php echo $taskInfo['id']?>" class="btn btn-warning">اسناد</button>
                        <?php endif?>
                      </td>-->
                      <td>
                         <?php
                        $today = new DateTime('now');
                        $date = new DateTime( $taskInfo["start"]);
                        if($today>=$date):?>
                        <div class="row ">
                        <form action="" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?php echo $taskInfo['id']?>">
                          <div class="col-md-6 pull-left">
                            <input id="exampleInputFile" name="fileUpload" type="file">
                          </div>
                          <div class="col-md-6 pull-left">
                            <button type="submit" name="finish" class="btn btn-success pull-left">Ending</button>
                          </div>
                        </form>
                        </div>
                      <?php endif?>
                      </td>
                    </tr>
                	<?php endforeach?>

                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
			    <!-- right column -->
			</div>
		</section>
	</div>

<?php
include "footer.php" ;
?>
