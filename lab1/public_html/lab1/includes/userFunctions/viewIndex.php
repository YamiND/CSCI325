<?php

function checkPermissions()
{
    if (login_check() == true)
    {
        viewIndex();
    }
}

function viewIndex()
{
	echo '
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						<h4>Index Page</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#createAnnoucement" data-toggle="tab">My Profile</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="myProfile">
                                 ';
						viewLinks();
echo '
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
        ';

}

function viewLinks()
{
	echo "<br>";

	foreach(glob("*") as $file) 
	{
		$siteName = shell_exec('cat ' . $file . ' | grep "displaySite" | cut -d \'(\' -f2 | cut -d \'"\' -f2');
		
		$link = '<a href="'. $file . '">' . $file . '</a>';
		echo "<p>" . $siteName . " -- " . $link . "</p>";
	}

}

?>
