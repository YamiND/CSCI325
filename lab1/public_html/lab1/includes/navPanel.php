<?php
include_once '../includes/functions.php';
include_once '../includes/panelSessionMessages.php';
include_once '../includes/formTemplate.php';

sec_session_start();

if (login_check() == true)
{
    //TODO: Update the email link to something more appropriate
    echo '

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index">Inventory Management</a>
                </div>
                <!-- /.navbar-header -->
                <ul class="nav navbar-top-links navbar-right">
    				<a href="settings"> ' . htmlentities($_SESSION['userEmail']) . '</a>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="viewProfile"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
                            <li><a href="settings"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="../includes/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
    ';

    echo '
            <li>
                <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard <span class="fa arrow"></span></a>
    			<ul class="nav nav-second-level">
    				<li>
    					<a href="index">Index</a>
    				</li>
    			</ul>	
            </li>
            <li>
                <a href="#"><i class="fa fa-book fa-fw"></i> Books <span class="fa arrow"></span></a>
    			<ul class="nav nav-second-level">
    				<li>
    					<a href="addbooks">Add a Book</a>
    				</li>
    				<li>
    					<a href="updatebooks">Modify a Book</a>
    				</li>
    				<li>
    					<a href="removebooks">Remove a Book</a>
    				</li>
    				<li>
    					<a href="books">View all Books</a>
    				</li>
    				<li>
    					<a href="booksbycourse">View Books by Course</a>
    				</li>
    				<li>
    					<a href="booksoutofstock">View out of Stock Books</a>
    				</li>
    			</ul>	
            </li>  
            <li>
                <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> Courses <span class="fa arrow"></span></a>
    			<ul class="nav nav-second-level">
    				<li>
    					<a href="addcourse">Add a Course</a>
    				</li>
    				<li>
    					<a href="updatecourse">Modify a Course</a>
    				</li>
    				<li>
    					<a href="removecourse">Remove a Course</a>
    				</li>
    				<li>
    					<a href="courses">View all Courses</a>
    				</li>
    			</ul>	
            </li>  
            <li>
                <a href="#"><i class="fa fa-user fa-fw"></i> Users <span class="fa arrow"></span></a>
    			<ul class="nav nav-second-level">
    				<li>
    					<a href="adduser">Add a User</a>
    				</li>
    				<li>
    					<a href="updateuser">Modify a User</a>
    				</li>
    				<li>
    					<a href="removeuser">Remove a User</a>
    				</li>
    				<li>
    					<a href="users">View all Users</a>
    				</li>
    				<li>
    					<a href="students">View all Students</a>
    				</li>
    				<li>
    					<a href="faculty">View all Faculty</a>
    				</li>
    			</ul>	
            </li>  
        ';

	echo '
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
	';
}
else
{
   	$url = "login"; 
}
?>
