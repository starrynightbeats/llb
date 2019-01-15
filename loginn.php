<?php
/**
 * Created by PhpStorm.
 * User: a1817
 * Date: 2018/10/31
 * Time: 17:30
 */
function SafeFilter(&$arr)
{
    $ra = Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '/script/', '/javascript/', '/vbscript/', '/expression/', '/applet/'
    , '/meta/', '/xml/', '/blink/', '/link/', '/style/', '/embed/', '/object/', '/frame/', '/layer/', '/title/', '/bgsound/'
    , '/base/', '/onload/', '/onunload/', '/onchange/', '/onsubmit/', '/onreset/', '/onselect/', '/onblur/', '/onfocus/',
        '/onabort/', '/onkeydown/', '/onkeypress/', '/onkeyup/', '/onclick/', '/ondblclick/', '/onmousedown/', '/onmousemove/'
    , '/onmouseout/', '/onmouseover/', '/onmouseup/', '/onunload/');

    if (is_array($arr)) {
        foreach ($arr as $key => $value) {
            if (!is_array($value)) {
                if (!get_magic_quotes_gpc())  //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
                {
                    $value = addslashes($value); //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）  加上反斜线转义
                }
                $value = preg_replace($ra, '', $value);     //删除非打印字符，粗暴式过滤xss可疑字符串
                $arr[$key] = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
            } else {
                SafeFilter($arr[$key]);
            }
        }
    }
}//php防注入和XSS攻击通用过滤
require_once('conn.php');
session_start();
//1. 获取到用户提交的验证码
$captcha = $_POST["captcha"];
//2. 将session中的验证码和用户提交的验证码进行核对,当成功时提示验证码正确，并销毁之前的session值,不成功则重新提交
if (strtolower($_SESSION["captcha"]) == strtolower($captcha)) {
    echo "验证码正确!";
    $_SESSION["captcha"] = "";
} else {
    //echo $_SESSION["captcha"];
    echo "<script>alert('验证码错误');location.href='login.php';</script>";
}
session_start();
// store session data
$_SESSION['username'] = $name;
$name = $_POST['username'];
$pwd = $_POST['password'];
SafeFilter($name);
SafeFilter($pwd);
$con = mysqli_connect("127.0.0.1", "root", "root");
mysqli_select_db($con, "test");
$sql_show = "select * from admin where username = '$name'";
$res = mysqli_query($con, $sql_show);

if ($res) {
    if (mysqli_num_rows($res) >= 1) {
        $sql2 = "select * from admin where username = '$name'";
        $res2 = mysqli_query($con, $sql2);
        $info = mysqli_fetch_array($res2);
        if ($info['password'] != $pwd) {
            echo "<script>alert('密码错误');location.href='login.php';</script>";
        } else {
            setcookie("user", "true", 0);
            setcookie("username", "$name", 0);
            echo "<script>alert('用户名和密码正确');location.href='message.php';</script>";
        }
    } else {
        echo "<script>alert('用户不存在，请注册');location.href='reg.php';</script>";
    }
}