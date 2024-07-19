<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">MRep Representative</a>
                <a class="navbar-brand hidden" href="./">MR</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php
                    if($currentmenu=="myduties"){
                        $menuselect="active";
                    }else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="progress_duty_map.php?rd_dutydate=<?php echo date("Y-m-d"); ?>"><i class="menu-icon fa fa-map"></i>My Duties</a>
                    </li>
					<?php
                    if($currentmenu=="dutylist"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_duty_report.php"><i class="menu-icon fa fa-map"></i>Duty Report</a>
                    </li>
                    <li >
                        <a href="logout_process.php"><i class="menu-icon fa  fa-power-off"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>