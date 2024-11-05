<?php
function getRole($role_id)
{
  include_once "./class/Database.php";
  $database = new Database();
  $connect = $database->getConnection();

  $sql = "SELECT * FROM Role WHERE id='$role_id'";

  try {
    $result = $connect->query($sql);
    $role = $result->fetch_assoc();
    return $role["name"] ?? "Guest";
  } catch (Exception $e) {
    echo $e;
  }

  return "Guest";
}

if (!isset($_SESSION)) { session_start(); }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $errors = [];

  if (empty($username)) {
    $errors[] = "You must provide an email";
  }

  if (empty($password)) {
    $errors[] = "You must provide a password";
  }

  if (empty($errors)) {

    include_once "./class/Database.php";
    $database = new Database();
    $connect = $database->getConnection();
    // Find user with username in db
    $query = "SELECT * FROM User WHERE username='$username'";
    $result = $connect->query($query);
    $user = $result->fetch_assoc();

    if (!$user) {
      $errors[] = "Username does not exist";
    } else {
      $isPasswordMatch = password_verify($password, $user["password"]);
      if ($isPasswordMatch) {
        $_SESSION['userId'] = $user["id"];
        $_SESSION['fullname'] = $user["fullname"];
        $_SESSION['role'] = getRole($user["role_id"]);
        header("Location: ./index.php");
      } else {
        $errors[] = "Password does not match";
      }
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

  <div class="container">
    <div style="max-width: 500px;" class="w-100 m-auto mt-5 p-5 rounded border">
      <h3 class="mb-3">Log In</h3>
      <form method="POST" , action="./login.php">
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
