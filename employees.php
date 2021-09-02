 <?php
     include "header.php" ;
     include "sidebar.php" ;
     ?>

<?php
if(isset($_POST['rate'])){

	$id = $_POST['id'];
	$rate=$_POST['rateVal'];
	if(!empty($id)){
		$sql = "UPDATE employee SET rate='$rate' where id='$id' ";
		$re = mysqli_query($comm,$sql);//perform query
		if(mysqli_connect_error()){
		die(mysqli_connect_error());
	}
	//header("location:employees.php");
}else {
	$message ="Please Enter  rate ";
}
}
$user_id= $_SESSION['id'];
$sql = "SELECT *,employee.id as employee_id FROM  users inner join employee on users.id=user_id where managerId='$user_id'";
$re = mysqli_query($comm,$sql);//perform query
if(mysqli_connect_error())
{
	die(mysqli_connect_error());
}
$i=0;
$usersInfo=array();
while($rows=mysqli_fetch_assoc($re)){
	$usersInfo[$i]["id"] = $rows['id'];
	$usersInfo[$i]["employee_id"] = $rows['employee_id'];
	$usersInfo[$i]["username"] = $rows['username'];
	$usersInfo[$i]["name"] = $rows['name'];
	$usersInfo[$i]["mobile"] = $rows['mobile'];

	$usersInfo[$i]["type"] = "employee";
	$usersInfo[$i]["email"] = $rows['email'];
	$usersInfo[$i]["rate"] = $rows['rate'];
	$i++;
}
?>
  <div class="content-wrapper" style="background-image: url('./homePage/img/aa1.jpeg');background-size: cover ;background-attachment: fixed;">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Employees 
            <small></small>
          </h1>

        </section>

        <!-- Main content -->
        <section class="content" style="direction: ltr;text-align: left;">
			<div  class="row">
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
                      <th style="direction: ltr;text-align: left;">Email</th>
                      <th style="direction: ltr;text-align: left;">Job</th>
                    <!--   <th style="direction: ltr;text-align: left;">mobile</th> -->
                        <th style="direction: ltr;text-align: left;">ID</th>
                      <th style="width: 40px">Evaluate</th>
                    </tr>

                    <?php foreach($usersInfo as $userInfo):?>
                    <tr>
                      <td><?php echo $userInfo["name"]?></td>
                      <td><?php echo $userInfo["username"]?></td>
                       <td><?php echo $userInfo["email"]?></td>
                      <?php if($userInfo["type"]=="admin"):?>
                      <td><span class="label label-success">manger</span></td>
                  	<?php elseif($userInfo["type"]=="info"):?>
                  	<td><span class="label label-primary">Data entry</span></td>
                  	 <?php else :?>
                  	<td><span class="label label-warning">Employee</span></td>
                  	<?php endif?>
                  		<!-- <td><?php echo $userInfo["mobile"]?></td> -->
                  		  <td><?php echo $userInfo["id"]?></td>
                      <td><span class="badge bg-red"><?php echo $userInfo["rate"]?>%</span></td>
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
			          <h3 class="box-title">Evaluation employee</h3>
			        </div><!-- /.box-header -->
			        <!-- form start -->
			        <form role="form" method="POST">
			          <div class="box-body">
			          	<div class="form-group">
			              <label for="exampleInputEmail1">Employee</label>
			             <select name="id" class="form-control">
			             	<?php foreach($usersInfo as $userInfo):?>
			             		<option value="<?php echo $userInfo['employee_id']?>"><?php echo $userInfo["name"]?></option>
			             	<?php endforeach?>
			              </select>
			            </div>
			           <div id="sliderdiv">
			           	 <label for="rateSlider">The Evaluate</label>
			           	<input type="text" id="rateSlider" value="" class="slider form-control" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="[0,100]" data-slider-orientation="horizontal"  data-slider-tooltip="show" data-slider-id="blue">
			           	<input type="hidden" id="rateVal" name="rateVal" value="0">
			           </div>
			           <span id="rateJS"></span>
			           <br>

			          </div><!-- /.box-body -->

			          <div class="box-footer">
			            <button type="submit" name="rate" class="btn btn-primary">Submit</button>
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

<script type="text/javascript">
	$slider= $("#rateSlider");
	$slider.slider().on('slide',function(){
		console.log(Math.abs($slider.data('slider').getValue()[0]-$slider.data('slider').getValue()[1]));
		$("#rateVal").val(Math.abs($slider.data('slider').getValue()[0]-$slider.data('slider').getValue()[1]));
		$("#rateJS").text(Math.abs($slider.data('slider').getValue()[0]-$slider.data('slider').getValue()[1]))
	})
</script>
