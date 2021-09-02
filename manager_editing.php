 <?php
     include "header.php" ;
     include "sidebar.php" ;
     ?>
<?php

if(isset($_GET["delete"]))
{
	$pId = $_GET["delete"];
		$sql = "DELETE FROM project where id='$pId'";
		//die($sql);
		$re = mysqli_query($comm,$sql);//perform query
		///header("location:manager_edititng.php");
}
if(isset($_GET["deleteTask"]))
{
	$tId = $_GET["deleteTask"];
		$sql = "DELETE FROM tasks where id='$tId'";
		//die($sql);
		$re = mysqli_query($comm,$sql);//perform query
		//header("location:manager_edititng.php");
}
if(isset($_POST['updateTask'])){
	$ids = $_POST["ids"];
	list ($projectId, $taskId ) = explode('_', $ids);
	$updateStr = "";
	$dates = $_POST['date'];
	if($dates !="")
	{
		list ($start_date, $end_date ) = explode(' - ', $dates);
		//$updateStr .= "start='$start_date',end='$end_date',";
		$sql = "UPDATE tasks dest, (SELECT '$start_date' as col1,'$end_date' as col2 from project where (start_date <= STR_TO_DATE('$start_date', '%Y-%m-%d'))and(end_date >= STR_TO_DATE('$end_date', '%Y-%m-%d'))and project.id='$projectId') src SET dest.start = src.col1, dest.end=src.col2 where dest.id='$taskId'";
		//die($sql);
		$re = mysqli_query($comm,$sql);//perform query
		if(mysqli_affected_rows($comm)==0)
		{
			$Bmessage="Please add the task within the project date";
		}
	}
	$taskname = $_POST['taskname'];
	if($taskname!=null && $taskname != "")
		$updateStr .= "taskName = '".$taskname."',";

	$employeeId = $_POST['employeeId'];
	$updateStr .= "employeeId = '".$employeeId."',";
	$notes = $_POST['notes'];
	if($notes != "")
		$updateStr .= "notes = '".$notes."',";
	/*$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];*/
	$updateStr = substr($updateStr, 0, -1);
	if($updateStr != ""){

		$sql = "UPDATE tasks SET $updateStr where id='$taskId'";
		//die($sql);
		$re = mysqli_query($comm,$sql);//perform query

		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}
		//header("location:manager_edititng.php");
}else {
	$Tmessage ="Please Enter  task name  or date";
}
}
if(isset($_POST['updateProject'])){
	$projectId=$_POST["projectId"];
	$updateStr = "";
	$where ="";
	$dates = $_POST['date'];
	if($dates !="")
	{
		list ($start_date, $end_date ) = explode(' - ', $dates);
		$updateStr .= "start_date='$start_date',end_date='$end_date',";
		//$where =" and start_date <= STR_TO_DATE('$start_date', '%Y-%m-%d')";
	}

	$Pname = $_POST['name'];
	if($Pname!=null && $Pname!='')
		$updateStr .= "projectName = '".$Pname."',";
	/*$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];*/
	$managerId=$_SESSION['id'];
	$updateStr = substr($updateStr, 0, -1);
	if($updateStr !=""){
		$sql = "UPDATE  project SET $updateStr where id='$projectId'";
		//echo $sql;die();
		$re = mysqli_query($comm,$sql);//perform query
		if(mysqli_affected_rows($comm)==0)
			$PMessage = "Can not select this date";
		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}
	//header("location:manager_edititng.php");
}else {
	$Pmessage ="Please Enter  project name or date";
}
}

$managerId=$_SESSION['id'];
$sql = "SELECT *,tasks.id as taskId,project.id as projectId FROM  tasks inner join employee on employee.id=employeeId inner join project on project.id=projectId

 where type='1' and start > NOW() and manager_id='$managerId'";
 //echo $sql;die();
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$tasksInfo=array();
while($rows=mysqli_fetch_assoc($re)){
	$tasksInfo[$i]["id"] = $rows['taskId'];
	$tasksInfo[$i]["projectId"] = $rows['projectId'];
	$tasksInfo[$i]["taskname"] = $rows['taskName'];
	$tasksInfo[$i]["name"] = $rows['name'];
	$tasksInfo[$i]["mobile"] = $rows['mobile'];
	$tasksInfo[$i]["start"] = $rows['start'];
	$tasksInfo[$i]["end"] = $rows['end'];
	$tasksInfo[$i]["notes"] = $rows['notes'];
	$tasksInfo[$i]["projectName"] = $rows['projectName'];
	$i++;
}

$sql = "SELECT * FROM  employee where managerId='$managerId'";
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$employee=array();
while($rows=mysqli_fetch_assoc($re)){
	$employee[$i]["id"] = $rows['id'];
	$employee[$i]["name"] = $rows['name'];
	$i++;
}
$managerId=$_SESSION['id'];
//echo "aaaa".$managerId;
$sql = "SELECT * FROM  project where manager_id='$managerId' and start_date > NOW()";
// 	die($sql);
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$projects=array();
while($rows=mysqli_fetch_assoc($re)){
	$projects[$i]["id"] = $rows['id'];
	$projects[$i]["projectName"] = $rows['projectName'];
	$projects[$i]["start_date"] = $rows['start_date'];
	$projects[$i]["end_date"] = $rows['end_date'];
	$i++;
}
?>

<link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
  <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;background-attachment: fixed;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          Manager
            <small></small>
          </h1>

        </section>

        <!-- Main content -->
        <section class="content" style="direction: ltr;text-align: left;">
			<div  class="row">
				  <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Project</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">Project</th>
                      <th style="direction: ltr;text-align: left;">Project Name</th>

                       <th style="direction: ltr;text-align: left;">Start Date</th>
                        <th style="direction: ltr;text-align: left;">End Date</th>
                         <th style="direction: ltr;text-align: left;">action</th>

                    </tr>

                    <?php foreach($projects as $project):?>
                    <tr>
                    	<td><?php echo $project["id"]?></td>
                      <td><?php echo $project["projectName"]?></td>
                      <td><?php echo $project["start_date"]?></td>
                  		 <td><?php echo $project["end_date"]?></td>

                      <td><a href="manager_editing.php?delete=<?php echo $project['id']?>" class="btn btn-danger">Delete</button></td>
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
			          <h3 class="box-title">Edit Project</h3>
			          	<?php if(isset($Pmessage)):?>
						<p class="login-box-msg" style="color:red"><?php echo $Pmessage ?></p>
					<?php endif?>
			        </div><!-- /.box-header -->
			        <!-- form start -->
			        <form role="form" method="POST">
			          <div class="box-body">
			          	<div class="form-group">
			              <label for="exampleInputEmail1">Select Project</label>
			              <select name="projectId" class="form-control">
	                      	<?php foreach($projects as $project):?>
	                      	<option value="<?php echo $project['id']?>"><?php echo $project['projectName']?></option>
	                        <?php endforeach?>
	                      </select>
			            </div>
			          	<div class="form-group">
			              <label for="exampleInputEmail1">Project Name</label>
			              <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name">
			            </div>
			           <div class="form-group">
			              <label for="exampleInputEmail1">Date of Project</label>
			               <div class="input-group-addon">
	                        <i class="fa fa-calendar"></i>
	                      </div>
			              <input type="text" name="date"  class="form-control pull-right" id="reservation"/>
			            </div>

			          </div><!-- /.box-body -->

			          <div class="box-footer">
			            <button type="submit" name="updateProject" class="btn btn-primary">Submit</button>
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
                  <h3 class="box-title">Task</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                    	<th style="width: 40px">Project Name</th>
                      <th style="width: 10px">Task</th>
                      <th style="direction: ltr;text-align: left;">Employee</th>

                       <th style="direction: ltr;text-align: left;">Mobile</th>
                        <th style="direction: ltr;text-align: left;">Start Date</th>
                         <th style="direction: ltr;text-align: left;">End Date</th>
                         <th style="direction: ltr;text-align: left;">Notes</th>

                    </tr>

                    <?php foreach($tasksInfo as $taskInfo):?>
                    <tr>
                    	<td><?php echo $taskInfo["projectName"]?></td>
                      <td><?php echo $taskInfo["taskname"]?></td>
                      <td><?php echo $taskInfo["name"]?></td>
                  		 <td><?php echo $taskInfo["mobile"]?></td>
                  		  <td><?php echo $taskInfo["start"]?></td>
                  		   <td><?php echo $taskInfo["end"]?></td>
                  		   <td><?php echo $taskInfo["notes"]?></td>
                     	 <td><a href="manager_editing.php?deleteTask=<?php echo $taskInfo['id']?>" class="btn btn-danger">Delete</button></td>
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
			          <h3 class="box-title">Edit Task</h3>
			          	<?php if(isset($Tmeessage)):?>
						<p class="login-box-msg" style="color:red"><?php echo $Tmessage ?></p>
						<?php endif?>
						<?php if(isset($Bmessage)):?>
						<p class="login-box-msg" style="color:red"><?php echo $Bmessage ?></p>
						<?php endif?>
			        </div><!-- /.box-header -->
			        <!-- form start -->
			        <form role="form" method="POST">
			          <div class="box-body">
			          	<div class="form-group">
	                      <label>Select Task</label>
	                      <select name="ids" class="form-control">
	                      	<?php foreach($tasksInfo as $task):?>
	                      	<option value="<?php echo $task['projectId']."_".$task['id']?>"><?php echo $task['taskname']?></option>
	                        <?php endforeach?>
	                      </select>
	                    </div>
			          	<div class="form-group">
	                      <label>Employee</label>
	                      <select name="employeeId" class="form-control">
	                      	<?php foreach($employee as $user):?>
	                      	<option value="<?php echo $user['id']?>"><?php echo $user['name']?></option>
	                        <?php endforeach?>
	                      </select>
	                    </div>
			          	<div class="form-group">
			              <label for="exampleInputEmail1">Task Name</label>
			              <input type="text" name="taskname" class="form-control" id="exampleInputEmail1" placeholder="Enter name">
			            </div>
			             <div class="form-group">
			              <label for="exampleInputEmail1">Task Date</label>
			               <div class="input-group-addon">
	                        <i class="fa fa-calendar"></i>
	                      </div>
			              <input type="text" name="date" class="form-control pull-right" id="reservation2"/>
			            </div>
			             <!--  <div class="form-group">
			              <label for="exampleInputEmail1">Start Date</label>
			              <input type="date" name="start_date">
			            </div>
			             <div class="form-group">
			              <label for="exampleInputEmail1">End Date</label>
			             <input type="date" name="end_date">
			            </div> -->
			            <div class="form-group">
			              <label for="exampleInputEmail1">Notes</label>
			              <textarea name="notes" class="form-control" ></textarea>
			            </div>

			          </div><!-- /.box-body -->

			          <div class="box-footer">
			            <button type="submit" name="updateTask" class="btn btn-primary">Submit</button>
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
