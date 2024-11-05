<?php if (!isset($_SESSION)) {
  session_start();
} ?>
<div class="w-100 border-bottom fw-semibold">
  <header class="container d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-1 ">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
      <img style="width: 45px; height: 45px;" src="../images/logo.png" alt="">
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 d-sm-none d-md-none d-lg-flex">
      <li><a href="/" class="nav-link px-3 link-secondary">Home</a></li>
      <li><a href="../about.php" class="nav-link px-3 link-dark">About</a></li>
      <li><a href="#" class="nav-link px-3 link-dark">Term & Policy</a></li>

    </ul>

    <?php if (isset($_SESSION["userId"])) : ?>
      <div class="d-flex gap-2 justify-content-center align-items-center">
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-md-none d-sm-none d-lg-block" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
        <div class="d-flex gap-2 btn btn-primary">
          <a class="text-white text-decoration-none" href="/cart/index.php">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
            <span class="badge text-bg-secondary"><?= count($_SESSION["cart"] ?? []) ?></span>
          </a>
        </div>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/images/default-avatar.png" alt="mdo" width="32" height="32" class="border rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="../users/profile.php">Profile</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') : ?>
              <li><a class="dropdown-item" href="/users/index.php">User Management</a></li>
              <li><a class="dropdown-item" href="/products/index.php">Product Management</a></li>
            <?php endif; ?>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/logout.php">Log out</a></li>
          </ul>
        </div>
      </div>
    <?php else : ?>
      <div class="col-md-3 text-end">
        <a href="/login.php" type="button" class="btn btn-sm btn-outline-primary me-2">Login</a>
        <a href="/signup.php" type="button" class="btn btn-sm btn-primary">Sign-up</a>
      </div>
    <?php endif; ?>
  </header>
</div>
