<?php
    include "header.php" ;
    include "sidebar.php" ;
    ?>
<link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<?php
if(isset($_POST['report'])){
 $dates = $_POST['date'];
 if($dates=="")
 {
  $message ="you should choose date";
 }
 else
 {
    list ($first, $last ) = explode(' - ', $dates);
 /*$sql = "SELECT * FROM  tasks inner join employee on employee.id=employeeId where type=0 and start between '$first' and '$last'";*/
 $managerId=$_SESSION['id'];
 $sql = "SELECT p.* FROM `project` p inner JOIN tasks on tasks.projectId = p.id
  where manager_id='$managerId' and end_date between '$first' and '$last'
 GROUP BY p.id HAVING COUNT(*)= (SELECT COUNT(*) FROM tasks where tasks.type =0 and tasks.projectId = p.id)";
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
   $sql = "SELECT * FROM tasks  inner join employee on employee.id=employeeId where projectId = '$pId'";
   $re2 = mysqli_query($comm,$sql);//perform query
   $j=0;
   while($rows2=mysqli_fetch_assoc($re2)){
     $projects[$i]["tasks"][$j]["taskname"] = $rows2['taskName'];
     $projects[$i]["tasks"][$j]["name"] = $rows2['name'];
     $projects[$i]["tasks"][$j]["mobile"] = $rows2['mobile'];
     $projects[$i]["tasks"][$j]["start"] = $rows2['start'];
     $projects[$i]["tasks"][$j]["end"] = $rows2['end'];
     $projects[$i]["tasks"][$j]["rate"] = $rows2['rate'];
     $projects[$i]["tasks"][$j]["extendedTask"] = $rows2['extendedTask'];
     $j++;
   }
   $i++;
 }
 }


}
?>
  <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover;background-attachment: fixed;">
       <!-- Content Header (Page header) -->
       <section class="content-header">
         <h1>
           Reports
           <small></small>
         </h1>

       </section>

       <!-- Main content -->
       <section class="content" style="direction: ltr;text-align: left;">
     <div  class="row">
       <div class="col-md-12">
           <!-- general form elements -->
           <div class="box box-primary">
             <div class="box-header">
               <h3 class="box-title">Reports </h3>
               <?php if(isset($message)):?>
                    <p class="login-box-msg" style="color:red"><?php echo $message ?></p>
             <?php endif?>
             </div><!-- /.box-header -->
             <!-- form start -->
             <form role="form" method="POST">
               <div class="box-body">
                 <div class="form-group">
                   <label for="exampleInputEmail1">The Date</label>
                    <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                   <input type="text" name="date" class="form-control pull-right" id="reservation3"/>
                 </div>

               </div><!-- /.box-body -->
               <center>
               <div class="box-footer">
                 <button type="submit" name="report" class="btn btn-primary">Submit</button>
               </div>
               </center>
             </form>
           </div><!-- /.box -->
         </div><!--/.col (left) -->
     </div>
     <div class="row">
      <?php if(isset($projects)):?>
                   <?php foreach($projects as $project):?>
           <div class="col-md-6 pull-right">
                   <div class="box">
                     <div class="box-header">
                       <h3 class="box-title">The project name : <?php echo  $project["projectName"]?></h3>
                     </div><!-- /.box-header -->
                     <div class="box-body">
                     Start Date: <?php echo $project["start_date"]?></br>
                     End Date : <?php echo $project["end_date"]?></br>
                      <table class="table table-bordered">
                          <tr>
                     <th style="width: 10px">Task</th>
                     <th style="direction: ltr;text-align: left;">Employee</th>

                      <th style="direction: ltr;text-align: left;">Mobile</th>
                       <th style="direction: ltr;text-align: left;">Start Date</th>
                        <th style="direction: ltr;text-align: left;">End Date</th>
                     <th style="width: 40px">The Evaluate</th>
                   </tr>

                         <?php foreach($project["tasks"] as $taskInfo):?>
                         <tr>
                           <td><?php echo $taskInfo["taskname"]?></td>
                           <td><?php echo $taskInfo["name"]?></td>
                            <td><?php echo $taskInfo["mobile"]?></td>
                             <td><?php echo $taskInfo["start"]?></td>
                              <td><?php echo $taskInfo["end"]?></td>
                           <td><span class="badge bg-red"><?php echo $taskInfo["rate"]?>%</span>
                           <?php if($taskInfo["extendedTask"]!=0):?>
                             <span class="badge bg-green">delay</span>
                           <?php endif?>
                           </td>
                         </tr>
                       <?php endforeach?>

                       </table>

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
