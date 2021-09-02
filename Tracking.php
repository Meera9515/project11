 <?php
 ob_start();
     include "header.php" ;
     include "sidebar.php" ;
     ?>
 <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<?php
$managerId=$_SESSION['id'];
$sql = "SELECT p.* FROM `project` p inner JOIN tasks on tasks.projectId = p.id where manager_id='$managerId' and start_date<=NOW() GROUP BY p.id HAVING COUNT(*)> (SELECT COUNT(*) FROM tasks where tasks.type =0 and tasks.projectId = p.id)";
	$re = mysqli_query($comm,$sql);//perform query
	if(mysqli_connect_error())
	{
		die(mysqli_connect_error());
	}
	$i=0;
	$projects=array();
	$tasks=array();
	while($rows=mysqli_fetch_assoc($re)){

		$pId= $rows['id'];
		$projects[$i]["id"] =$pId;
		$projects[$i]["projectName"] = $rows['projectName'];
		$projects[$i]["start_date"] = $rows['start_date'];
		$projects[$i]["end_date"] = $rows['end_date'];
		$projects[$i]["extended"] = $rows['extended'];
		$sql = "SELECT *,tasks.id as task_id FROM tasks  inner join employee on employee.id=employeeId where projectId = '$pId'";
		$re2 = mysqli_query($comm,$sql);//perform query
		$j=0;$completed=0;
		while($rows2=mysqli_fetch_assoc($re2)){
			$projects[$i]["tasks"][$j]["taskname"] = $rows2['taskName'];
			$projects[$i]["tasks"][$j]["id"] = $rows2['task_id'];
			$projects[$i]["tasks"][$j]["name"] = $rows2['name'];
			$projects[$i]["tasks"][$j]["mobile"] = $rows2['mobile'];
			$projects[$i]["tasks"][$j]["start"] = $rows2['start'];
			$projects[$i]["tasks"][$j]["end"] = $rows2['end'];
			$projects[$i]["tasks"][$j]["rate"] = $rows2['rate'];
			$projects[$i]["tasks"][$j]["type"] = $rows2['type'];
			$projects[$i]["tasks"][$j]["extendedTask"] = $rows2['extendedTask'];
			if($rows2['type']==0)
				$completed++;
			$j++;
		}
		$projects[$i]["completedTasks"] = $completed/$j*100;
		$i++;
	}
?>
<?php
if(isset($_POST["extend"]))
{
	$end_date = $_POST["end_date"];
	$pId = $_POST["Pid"];
	$sql = "update project set end_date='$end_date',extended=1 where id='$pId' and STR_TO_DATE('$end_date', '%Y-%m-%d')>=NOW()";
//	die($sql);
	$re2 = mysqli_query($comm,$sql);//perform query

		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}
	header("location:Tracking.php");
}
if(isset($_POST["extendTask"]))
{
	$end_date = $_POST["end_date"];
	$tId = $_POST["id"];
	$projectId =$_POST["projectId"];
	$sql = "update tasks set end='$end_date',extendedTask=1 where id='$tId'";
	$sql = "UPDATE tasks dest, (SELECT '$end_date' as col2 from project where (end_date >=STR_TO_DATE('$end_date', '%Y-%m-%d') and STR_TO_DATE('$end_date', '%Y-%m-%d')>=NOW())and project.id='$projectId') src SET  dest.end=src.col2,dest.extendedTask=1 where dest.id='$tId'";

	//die($sql);
	$re2 = mysqli_query($comm,$sql);//perform query
	if(mysqli_affected_rows($comm)==0)
		{
			echo '<script type="text/javascript">alert("Please add the task within the project date");</script>';
		}
	//header("Location:Tracking.php");
		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}

}
?>
<script type="text/javascript"></script>
  <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;background-attachment: fixed;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Task Tracking
            <small></small>
          </h1>

        </section>

        <!-- Main content -->
        <section class="content" style="direction: ltr;text-align: left;">
			<div class="row">
			 <?php if(isset($projects)):?>
                    <?php foreach($projects as $project):?>
						<div class="col-md-6 pull-right">
			              <div class="box">
			                <div class="box-header">
			                  <h3 class="box-title">project name : <?php echo  $project["projectName"]?>&nbsp; <span class="badge bg-red"><?php echo $project["completedTasks"]?>%</span></h3>
			                </div><!-- /.box-header -->
			                <div class="box-body">
			               	Start Date : <?php echo $project["start_date"]?></br>
			                End Date : <?php echo $project["end_date"]?></br>
			                <br>
			                <?php
			                	$today = new DateTime('now');
								$date = new DateTime( $project["end_date"]);
			                	if($today>=$date):?>
			                	<form name="editProject" method="POST">
 									<input type="hidden" name="Pid" value ="<?php echo $project['id']?>">
 									<input type="date" name="end_date">
 									<input type="submit" value="modify" class="btn btn-success" name="extend">
			                	</form>
			                <?php endif?>

			                 <table class="table table-bordered">
			                     <tr>
                      <th style="width: 10px">Task</th>
                      <th style="direction: ltr;text-align: left;">Employee Name</th>

                       <th style="direction: ltr;text-align: left;">mobile</th>
                        <th style="direction: ltr;text-align: left;">start Date</th>
                         <th style="direction: ltr;text-align: left;">End Date</th>
                      <th style="width: 40px">Completion rate</th>
                    </tr>

			                    <?php foreach($project["tasks"] as $taskInfo):?>
			                    <tr>
			                      <td><?php echo $taskInfo["taskname"]?></td>
			                      <td><?php echo $taskInfo["name"]?></td>
			                  		 <td><?php echo $taskInfo["mobile"]?></td>
			                  		  <td><?php echo $taskInfo["start"]?></td>
			                  		   <td><?php echo $taskInfo["end"]?></td>
			                  		 <?php if($taskInfo["type"]==0):?>
			                     		 <td><span class="badge bg-red">100%</span></td>
			                 		 <?php else :?>
			                 		 	 <td><span class="badge bg-red">0%</span>

			                 		 	 </td>
			                 		 <?php endif?>
			                    </tr>
			                	<?php endforeach?>

			                  </table>
			             	<?php
			             		if($project["extended"]==1):
			             	?>
			             	<form name="editProject" method="POST">
			             			<div class="form-group">
				                      <label>Select the task</label>
				                      <select name="id" class="form-control">
				                      	<?php foreach($project["tasks"] as $task):?>
				                      	<?php if($task["type"]!=0 && $task["extendedTask"]!=1):?>
				                      	<option value="<?php echo $task['id']?>"><?php echo $task['taskname']?></option>
				                      	<?php endif?>
				                        <?php endforeach?>
				                      </select>
				                      <input type="date" name="end_date">
				                      <input type="hidden" name="projectId" value ="<?php echo $project['id']?>">
 									<input type="submit" value="modify" class="btn btn-success" name="extendTask">
				                    </div>
				                </form>
			             <?php endif?>
			                </div><!-- /.box-body -->
			              </div><!-- /.box -->
			            </div>
				 <?php endforeach?>
			 <?php endif?>
			    <!-- right column -->
			</div>
		</section>
	</div>

<?php
include "footer.php" ;
?>
