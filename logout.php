<?php
/**
 * Created by PhpStorm.
 * User: a1817
 * Date: 2018/10/31
 * Time: 21:18
 */

setcookie('user', "null");
setcookie('username', "null");
unset($_COOKIE['user']);
unset($_COOKIE['username']);
echo "<script>alert('ÍË³ö³É¹¦');location.href='login.php';</script>";