<?php
$path_parts = explode('/', $_SERVER['PHP_SELF']);
$page = end($path_parts);
?>
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
            <img width="60" height="48" src="https://img.icons8.com/color/48/student-male--v1.png" alt="administrator-male--v1"/>
        </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo $page=='index.php'?'active':'';?>">
                    <a href="index.php" >
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                </li>
                <li class="nav-item <?php echo $page=='fees_record.php'?'active':'';?>">
                    <a href="fees_record.php">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Fee</p>  
                    </a>
                </li> 
                 <li class="nav-item <?php echo $page=='payment.php'?'active':'';?>">
                    <a href="stripe\index.php">
                    <i class=" fas fa-solid fa-dollar-sign"></i>
                    <p>Payment</p>  
                    </a>
                </li> 
            </ul>
        </div>
    </div>
</div>