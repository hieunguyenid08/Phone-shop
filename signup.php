<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST["name"];
  $username = $_POST["username"];
  $password = $_POST["password"];

  $errors = [];

  if (empty($fullname)) {
    $errors[] = "You must provide a fullname";
  }

  if (empty($username)) {
    $errors[] = "You must provide a username";
  }

  if (empty($password)) {
    $errors[] = "You must provide a password";
  }

  if (empty($errors)) {
    // Create new user
    include_once "./class/Database.php";
    $database = new Database();
    $connect = $database->getConnection();
    // Add to database

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $createdAt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO User (fullname, username, password, created_at)
               VALUES ('$fullname','$username', '$hashedPassword', '$createdAt')";

    try {
      $connect->query($sql);
      $connect->close();
      header("Location:./login.php");
    } catch (Exception $e) {
      $errors[] = $connect->error;
      $connect->close();
    }
  }
}
?>


<?php include_once "./includes/header.php"; ?>

<body>
  <?php include_once "./includes/navbar.php" ?>

  <?php if (!empty($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="container mt-3">
    <div style="max-width: 500px;" class="w-100 m-auto mt-5 p-5 rounded border">
      <h3 class="mb-3">Register</h3>
      <form method="POST" , action="signup.php">
        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" name="name" id="name">
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username">
        </div>
        <div class="mb-3">
          <label for="passoword" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</body>
