<body class="fixed-sn light-blue-skin">

  <!--Double navigation-->
  <header>
    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav sn-bg-4 fixed">
      <ul class="custom-scrollbar">
        <!-- Logo -->
        <li>
          <div class="logo-wrapper waves-light">
            <a href="#"><img src="../public/img/go.png" class="img-fluid flex-center"></a>
          </div>
        </li>
        <!--/. Logo -->
        <!--Social-->
        <!-- <li>
          <ul class="social">
            <li><a href="#" class="icons-sm fb-ic"><i class="fab fa-facebook-f"> </i></a></li>
            <li><a href="#" class="icons-sm pin-ic"><i class="fab fa-pinterest"> </i></a></li>
            <li><a href="#" class="icons-sm gplus-ic"><i class="fab fa-google-plus-g"> </i></a></li>
            <li><a href="#" class="icons-sm tw-ic"><i class="fab fa-twitter"> </i></a></li>
          </ul>
        </li> -->
        <!--/Social-->
        <!--Search Form-->
        <!-- <li>
          <form class="search-form" role="search">
            <div class="form-group md-form mt-0 pt-1 waves-light">
              <input type="text" class="form-control" placeholder="Search">
            </div>
          </form>
        </li> -->
        <!--/.Search Form-->
        <!-- Side navigation links -->
        <li>
          <ul class="collapsible collapsible-accordion">
            <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-user"></i> Patients<i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
                  <?php if ($_SESSION['role'] != "admin") : ?>
                    <li><a href="../patients/addPatient.php" class="waves-effect">Add Patient</a>
                    </li>
                  <?php endif; ?>
                  <li><a href="../patients/viewPatients.php" class="waves-effect">View Patients List</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php if ($_SESSION['role'] == "admin") : ?>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-cross"></i>
                  Drug<i class="fas fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="../presp/addPresp.php" class="waves-effect">Add Drug</a>
                    </li>
                    <li><a href="../presp/viewPresp.php" class="waves-effect">View Drugs</a>
                    </li>
                  </ul>
                </div>
              </li>
            <?php endif; ?>

            <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-folder">
                </i> Requisitions<i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="../req/addReq.php" class="waves-effect">Add Drug Requisition</a>
                  </li>
                  <li><a href="../req/viewReq.php" class="waves-effect">View Requisitions</a>
                  </li>
                  <?php if ($_SESSION['role'] == "admin") : ?>
                    <li><a href="../req/report.php" class="waves-effect">View Requisitions Report</a>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </li>
            <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-plus">
                </i> Diagnosis<i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="../diag/viewDiag.php" class="waves-effect">View Diagnosis</a>
                  </li>
                </ul>
              </div>
            </li>
            <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-group"></i> Children<i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="../growth/viewChildren.php" class="waves-effect">Update Child Details</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php if ($_SESSION['role'] == "admin") : ?>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-group"></i> Users<i class="fas fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="../users/addUser.php" class="waves-effect">Add User</a>
                    </li>
                    <li><a href="../users/viewUsers.php" class="waves-effect">View Users</a>
                    </li>
                  </ul>
                </div>
              </li>
            <?php endif; ?>
          </ul>
        </li>
        <!--/. Side navigation links -->
      </ul>
      <div class="sidenav-bg mask-strong"></div>
    </div>
    <!--/. Sidebar navigation -->
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
      <!-- SideNav slide-out button -->
      <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
      </div>
      <!-- Breadcrumb-->
      <div class="breadcrumb-dn mr-auto">
        <p>Hospital Infomation System</p>
      </div>
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item">
          <a class="nav-link"><i class="fas fa-envelope"></i> <span class="clearfix d-none d-sm-inline-block">Contact</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link"><i class="far fa-comments"></i> <span class="clearfix d-none d-sm-inline-block">Support</span></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> Account
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../index/index.php">Log Out [<?= $_SESSION['email'] ?>]</a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.Navbar -->
  </header>
</body>