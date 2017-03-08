<?php

function errorPage($args)
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Error Page");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
	'
			echo $args;
echo ';
			
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
';

}

?>
