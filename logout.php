<?php
   if (!isset($_SESSION)) { session_start(); }
   unset($_SESSION['userId']);
   unset($_SESSION['fullname']);
   unset($_SESSION['role']);
   unset($_SESSION['cart']);
   unset($_SESSION['total']);
   header("Location:./index.php");
