 <?php
     include "header.php" ;
     include "sidebar.php" ;
     ?>
<link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<?php
if(isset($_POST['addTask'])){
  $dates = $_POST['date'];
  if($dates!="")
    list ($start_date, $end_date ) = explode(' - ', $dates);
  $taskname = $_POST['taskname'];
  $employeeId = $_POST['employeeId'];
  $projectId = $_POST['projectId'];
  $notes = $_POST['notes'];
  /*$start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];*/

  if(!empty($taskname) && !empty($employeeId) && !empty($dates)){

    $sql = "INSERT INTO  tasks (taskName,employeeId,notes,projectId,start,end) Select '$taskname','$employeeId','$notes','$projectId','$start_date','$end_date' from project where (start_date <= STR_TO_DATE('$start_date', '%Y-%m-%d'))and(end_date >= STR_TO_DATE('$end_date', '%Y-%m-%d'))and project.id='$projectId'";
    //die($sql);
    $re = mysqli_query($comm,$sql);//perform query
    $id= mysqli_insert_id($comm);
    $sql2 = "SELECT * FROM  tasks WHERE id = '$id' ";
     $re2 = mysqli_query($comm,$sql2);//perform query
     if($re2->num_rows ==0){
     $Bmessage="Please add the task within the project date";
    }
    /*if(mysqli_affected_rows()==0)
    {
      $Bmessage="يرجى اضافة المهمة ضمن تاريخ المشروع المعطى";
    }*/
    if(mysqli_connect_error()){
    die(mysqli_connect_error());
  }
  /*if(!isset($Bmessage))
    header("location:manager.php");*/
}else {
  $Tmessage ="Please Enter  task name  or date";
}
}
if(isset($_POST['addProject'])){
  $dates = $_POST['date'];
  if($dates!="")
    list ($start_date, $end_date ) = explode(' - ', $dates);
  $Pname = $_POST['name'];
  /*$start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];*/
  $managerId=$_SESSION['id'];

  if(!empty($Pname) && !empty($dates)){
    $sql = "INSERT INTO  project (projectName,start_date,end_date,manager_id) values ('$Pname','$start_date','$end_date','$managerId') ";
    $re = mysqli_query($comm,$sql);//perform query

    if(mysqli_connect_error()){
    die(mysqli_connect_error());
  }
  //header("location:manager.php");
}else {
  $Pmessage ="Please Enter  project name or date";
}
}
$managerId=$_SESSION['id'];
$sql = "SELECT * FROM  tasks inner join employee on employee.id=employeeId inner join project on project.id=projectId

 where type='1' and  manager_id='$managerId'";
 //echo $sql;die();
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
  die(mysqli_connect_error());
}
$i=0;
$tasksInfo=array();
while($rows=mysqli_fetch_assoc($re)){
  $tasksInfo[$i]["id"] = $rows['id'];
  $tasksInfo[$i]["taskname"] = $rows['taskName'];
  $tasksInfo[$i]["name"] = $rows['name'];
  $tasksInfo[$i]["mobile"] = $rows['mobile'];
  $tasksInfo[$i]["start"] = $rows['start'];
  $tasksInfo[$i]["end"] = $rows['end'];
  $tasksInfo[$i]["notes"] = $rows['notes'];
  $tasksInfo[$i]["projectName"] = $rows['projectName'];
  $i++;
}
$managerId=$_SESSION['id'];
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
$sql = "SELECT * FROM  project where manager_id='$managerId'";
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
<div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover ;background-attachment: fixed;">

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
                  <h3 class="box-title">Project </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">Project</th>
                      <th style="direction: ltr;text-align: left;">Project Name</th>

                       <th style="direction: ltr;text-align: left;">Start Date</th>
                        <th style="direction: ltr;text-align: left;">End Date</th>

                    </tr>

                    <?php foreach($projects as $project):?>
                    <tr>
                      <td><?php echo $project["id"]?></td>
                      <td><?php echo $project["projectName"]?></td>
                      <td><?php echo $project["start_date"]?></td>
                       <td><?php echo $project["end_date"]?></td>


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
                <h3 class="box-title">Create Project</h3>
                  <?php if(isset($Pmessage)):?>
            <p class="login-box-msg" style="color:red"><?php echo $Pmessage ?></p>
          <?php endif?>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form role="form" method="POST">
                <div class="box-body">

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
                  <button type="submit" name="addProject" class="btn btn-primary">Submit</button>
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
                  <h3 class="box-title">Tasks</h3>
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
                <h3 class="box-title">Add Task</h3>
                  <?php if(isset($Tmessage)):?>
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
                        <label>Project Name</label>
                        <select name="projectId" class="form-control">
                          <?php foreach($projects as $project):?>
                          <option value="<?php echo $project['id']?>"><?php echo $project['projectName']?></option>
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
                    <label for="exampleInputEmail1">Date of Task</label>
                     <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                    <input type="text" name="date" class="form-control pull-right" id="reservation2"/>
                  </div>
                   <!--  <div class="form-group">
                    <label for="exampleInputEmail1">تاريخ البداية</label>
                    <input type="date" name="start_date">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">تاريخ النهاية</label>
                   <input type="date" name="end_date">
                  </div> -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Notes</label>
                    <textarea name="notes" class="form-control" ></textarea>
                  </div>

                </div><!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" name="addTask" class="btn btn-primary">Submit</button>
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
