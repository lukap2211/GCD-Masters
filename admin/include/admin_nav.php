<div class="navbar">
  <div class="navbar-inner">
    <div class="container2">
<!--       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
 -->
      <a class="brand" href="dashboard.php"><?="Hi {$_SESSION['username']}" ?></a>

      <!-- <div class="nav-collapse collapse"> -->
      <div >
        <ul class="nav">
          <li class="dropdown active">
            <a href="dashboard.php" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-home"></i></a>
            <ul class="dropdown-menu">
              <li><a class="set_map" data-map="gcd" href="#"><i class="icon-fixed-width icon-globe"></i> GCD Campus</a></li>
              <li><a class="set_map" data-map="smi" href="#"><i class="icon-fixed-width icon-globe"></i> Smithfield Square</a></li>
              <li><a class="set_map" data-map="pho" href="#"><i class="icon-fixed-width icon-globe"></i> Phoenix Park</a></li>
              <li><a class="set_map" data-map="dub" href="#"><i class="icon-fixed-width icon-globe"></i> Dublin</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav pull-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-cogs"></i> Settings <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a class="user" href="user.php?id=<?= $_SESSION['id'] ?>&amp;action=view"><i class="icon-fixed-width icon-user"></i> Me</a></li>
              <?php if ($_SESSION['privilege'] == "admin" ) { ?>
              <li><a class="users" href="#"><i class="icon-fixed-width icon-group"></i> Users</a></li>
              <li><a class="settings" href="#"><i class="icon-fixed-width icon-globe"></i> Site</a></li>
              <?php } ?>
              <li class="divider"></li>
              <li><a href="logout.php"><i class="icon-fixed-width icon-signout"></i> Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>