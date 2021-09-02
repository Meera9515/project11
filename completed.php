<?php
    include "header.php" ;
    include "sidebar.php" ;
    ?>

<?php
if(isset($_POST['editTask'])){
 $id = $_POST['taskId'];
 $notes = $_POST['notes'];


   $sql = "UPDATE  tasks set notes='$notes',type=1  where id='$id' ";
   $re = mysqli_query($comm,$sql);//perform query

   if(mysqli_connect_error()){
   die(mysqli_connect_error());

 header("location:manager.php");
}else {
 $message ="Please Enter  task name or employee";
}
}
$managerId=$_SESSION['id'];
$sql = "SELECT *,tasks.id as taskId FROM  tasks inner join employee on employee.id=employeeId inner join project on projectId=project.id where type=0 and manager_id='$managerId'";
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
 die(mysqli_connect_error());
}
$i=0;
$tasksInfo=array();
while($rows=mysqli_fetch_assoc($re)){
 $tasksInfo[$i]["id"] = $rows['taskId'];
 $tasksInfo[$i]["taskname"] = $rows['taskName'];
 $tasksInfo[$i]["name"] = $rows['name'];
 $tasksInfo[$i]["mobile"] = $rows['mobile'];
 $tasksInfo[$i]["start"] = $rows['start'];
 $tasksInfo[$i]["end"] = $rows['end'];
 $tasksInfo[$i]["file"] = $rows['file'];
 $i++;
}

$sql = "SELECT * FROM  employee";
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
?>
 <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;background-attachment: fixed;">

       <!-- Content Header (Page header) -->
       <section class="content-header">
         <h1>
           completed tasks
           <small></small>
         </h1>

       </section>

       <!-- Main content -->
       <section class="content" style="direction: ltr;text-align: left;">
     <div  class="row">
         <div class="col-md-6">
             <div class="box">
               <div class="box-header">
                 <h3 class="box-title">Table of executed tasks</h3>
               </div><!-- /.box-header -->
               <div class="box-body">
                 <table class="table table-bordered">
                   <tr>
                     <th style="width: 10px">Task</th>
                     <th style="direction: ltr;text-align: left;">Employee</th>

                      <th style="direction: ltr;text-align: left;">Mobile</th>
                       <th style="direction: ltr;text-align: left;">Start Date</th>
                        <th style="direction: ltr;text-align: left;">End Date</th>
                         <th style="direction: ltr;text-align: left;">The attached file</th>

                   </tr>

                   <?php foreach($tasksInfo as $taskInfo):?>
                   <tr>
                     <td><?php echo $taskInfo["taskname"]?></td>
                     <td><?php echo $taskInfo["name"]?></td>
                      <td><?php echo $taskInfo["mobile"]?></td>
                       <td><?php echo $taskInfo["start"]?></td>
                        <td><?php echo $taskInfo["end"]?></td>
                           <td><a href="<?php echo "uploads/".$taskInfo["file"]?>"><?php echo $taskInfo["file"]?></a></td>

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
               <h3 class="box-title">Modify a task </h3>
             </div><!-- /.box-header -->
             <!-- form start -->
             <form role="form" method="POST">
               <div class="box-body">
                 <div class="form-group">
                   <label for="exampleInputEmail1">Task name</label>
                   <select name="taskId" class="form-control">
                         <?php foreach($tasksInfo as $task):?>
                         <option value="<?php echo $task['id']?>"><?php echo $task['taskname']?></option>
                         <?php endforeach?>
                       </select>
                 </div>
                 <div class="form-group">
                   <label for="exampleInputEmail1">Notes</label>
                   <textarea name="notes" class="form-control" ></textarea>
                 </div>

               </div><!-- /.box-body -->

               <div class="box-footer">
                 <button type="submit" name="editTask" class="btn btn-primary">Submit</button>
               </div>
             </form>
           </div><!-- /.box -->
         </div><!--/.col (left) -->
         <!-- right column -->
     </div>
   </section>
 </div>

<?php
include "footer.php" ;
?>
