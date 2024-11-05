<?php

function getRole($role_id)
{
  include_once "../class/Database.php";
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
