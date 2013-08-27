        <?php if ($_SESSION['privilege'] == "admin" ) { ?><div class="admin"><span>ADMIN</span></div><?php } ?>

        <div class="navbar">
            <div class="navbar-inner">

                <span id="user" class="brand" href="#" data-user-id=<?=$_SESSION['id']?> data-user-privilege=<?=$_SESSION['privilege']?> > Hi <?=$_SESSION['username']?></span>
                <div>
                    <ul class="nav">
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-home"></i></a>
                            <ul class="dropdown-menu">
                                <li><a class="set_map" data-map="gcd" href="#"><i class="icon-fixed-width icon-globe"></i> GCD Campus</a></li>
                                <li><a class="set_map" data-map="smi" href="#"><i class="icon-fixed-width icon-globe"></i> Smithfield Square</a></li>
                                <li><a class="set_map" data-map="pho" href="#"><i class="icon-fixed-width icon-globe"></i> Phoenix Park</a></li>
                                <li><a class="set_map" data-map="dub" href="#"><i class="icon-fixed-width icon-globe"></i> Dublin</a></li>
                                <?php if ($_SESSION['privilege'] == "admin" ) { ?>
                                <li class="divider"></li>
                                <li><a class="edit_map" href="#"><i class="icon-fixed-width icon-pencil"></i> Edit Locations</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php if ($_SESSION['privilege'] == "admin" ) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-eye-open"></i> View as <span id="view-as"><?="{$_SESSION['first_name']} {$_SESSION['last_name']}"?></span> <b class="caret"></b> </a>
                            <ul id="viewAsId" class="dropdown-menu">
                                <li class="divider"></li>
                                <li><a class="view_as" data-user-id="<?=$_SESSION['id']?>" data-user-fullname="<?="{$_SESSION['first_name']} {$_SESSION['last_name']}"?>" href="#"><i class="icon-fixed-width icon-user"></i> <?="{$_SESSION['first_name']} {$_SESSION['last_name']}"?> (admin)</a></li>
                            </ul>
                        </li>
                        <?php } else { ?>
                        <li class="dropdown">
                            <a href="javascript:void(0);" ><?="{$_SESSION['first_name']} {$_SESSION['last_name']}"?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-cogs"></i> Settings <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a class="user" href="#"><i class="icon-fixed-width icon-wrench"></i> My Settings</a></li>
                                <?php if ($_SESSION['privilege'] == "admin" ) { ?>
                                <li><a class="users" data-slide-index="0" href="modal-users"><i class="icon-fixed-width icon-wrench"></i> Users </a></li>
                                <li><a class="settings" data-slide-index="0" href="site-modal"><i class="icon-fixed-width icon-wrench"></i> Site Settings</a></li>
                                <?php } ?>
                                <li class="divider"></li>
                                <li><a href="logout.php"><i class="icon-fixed-width icon-off"></i> Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>