<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-1" href="index.html">
          <img src="<?php echo e(asset('skydash/images/logo_GS_1.png')); ?>" alt="logo" width="50" height="50"/>
          <span class="brand-text" style="vertical-align: middle; font-size: 18px; font-weight: bold; color: #333;">GUNUNG SLAMAT</span>
      </a>
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?php echo e(asset('skydash/images/logo_GS_1.png')); ?>" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="<?php echo e(asset('skydash/images/faces/face28.jpg')); ?>" alt="profile"/>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item">
              <i class="ti-settings text-primary"></i>
              Settings
            </a>
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;" id="logout-form">
                <?php echo csrf_field(); ?>
            </form>

            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ti-power-off text-primary"></i>
                Logout
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
</nav><?php /**PATH D:\Latihan\pkl\resources\views/layout/navbar.blade.php ENDPATH**/ ?>