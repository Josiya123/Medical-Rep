<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">MRep Admin</a>
                <a class="navbar-brand hidden" href="./">MA</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php
                    if($currentmenu=="products"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_products.php"> <i class="menu-icon fa fa-flask"></i>Products</a>
                    </li>
                    <?php
                    if($currentmenu=="teamleaders"){
                        $menuselect="active";
                    }
                    else{
                        $menuselect="";
                    }
                    ?>
                    <li class="<?php echo $menuselect; ?>">
                        <a href="list_teamleadrs.php"><i class="menu-icon fa fa-group"></i>Team Leaders</a>
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
                    <li >
                        <a href="logout_process.php"><i class="menu-icon fa fa fa-power-off"></i>Logout</a>
                    </li>
                    
                </ul>
            </div>
        </nav>
    </aside>