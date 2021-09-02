 <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
          
            <div class="pull-left info">
              <p><?php echo $_SESSION['Username'];?></p>


            </div>
          </div>
          <!-- search form -->

          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">

             <li>
              <a href="index.php">
                <i class="fa fa-th"></i> <span>Home</span>
              </a>
            </li>
            <?php if($_SESSION["type"]=="manager"):?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Tasks</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="Tracking.php"><i class="fa fa-circle-o"></i> Tracking</a></li>
                <li><a href="manager.php"><i class="fa fa-circle-o"></i>Add project</a></li>
                <li><a href="completed.php"><i class="fa fa-circle-o"></i>Completed Task</a></li>
                <!--<li><a href="assigned.php"><i class="fa fa-circle-o"></i> المهمات المسندة</a></li>-->
                <li><a href="manager_editing.php"><i class="fa fa-circle-o"></i>Edit</a></li>
              </ul>
            </li>
              <li>
              <a href="employees.php">
                <i class="fa fa-th"></i> <span>Employees</span>
              </a>
            </li>
             <li>
              <a href="Reports.php">
                <i class="fa fa-th"></i> <span>Report</span>
              </a>
            </li>
          <?php endif?>
           <?php if($_SESSION["type"]=="employee"):?>
              <li>
              <a href="employee.php">
                <i class="fa fa-th"></i> <span>Tasks</span>
              </a>
            </li>
          <?php endif?>
           <?php if($_SESSION["type"]=="info"):?>
              <li>
              <a href="info.php">
                <i class="fa fa-th"></i> <span>Employees</span>
              </a>
            </li>
          <?php endif?>



          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
