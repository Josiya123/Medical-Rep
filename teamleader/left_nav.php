<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">MRep TeamLeader</a>
                <a class="navbar-brand hidden" href="./">MT</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php
                    if($currentmenu=="hospitals"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_hospitals.php"> <i class="menu-icon fa fa-plus-square"></i>Hospitals/Clinics/Shops</a>
                    </li>
                    <?php
                    if($currentmenu=="doctors"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_doctors.php"> <i class="menu-icon fa fa-stethoscope"></i>Doctors</a>
                    </li>
                    <?php
                    if($currentmenu=="mymap"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="my_map_view.php"><i class="menu-icon fa fa-map"></i>My Map</a>
                    </li>
         
                    <?php
                    if($currentmenu=="representative"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_representatives.php"><i class="menu-icon fa fa-briefcase"></i>Representatives</a>
                    </li>
                    <?php
                    if($currentmenu=="dutyprogress"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_representatives_1.php"><i class="menu-icon fa  fa-exchange"></i>Duty Progress</a>
                    </li>					
                    <?php
                    if($currentmenu=="todaydutyprogress"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <!--<li class="<?php echo $menuselect; ?>">
                        <a href="list_duties_today.php"><i class="menu-icon fa  fa-exchange"></i>Today Duty Progress</a>
                    </li>-->
					
                    <li >
                        <a href="logout_process.php"><i class="menu-icon fa  fa-power-off"></i>Logout</a>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </aside>