<!DOCTYPE html>
<html>
<head>
    <meta charset="gbk">
    <title>留言板用户注册</title>
</head>
<body>
<div id="div">
    <h3>留言板用户注册</h3>
    <div id="cnt">
        <form method="post" action="regin.php">
            用户名<input type="text" placeholder="请输入用户名" name="username">
            <br><br>
            密码<input type="password" placeholder="请输入密码" name="password">
            <br><br>
            确认密码<input type="password" placeholder="请再次输入密码" name="password2">
            <br><br>
            注册邮箱<input type="text" placeholder="请输入注册邮箱" name="email">
            <br><br>
            验证码
            <img src="image.php" onclick="this.src='image.php?'+new Date().getTime();" width="80" height="48"><br/>
            <input type="text" name="captcha" placeholder="请输入图片中的验证码"><br/>
            <input type="submit" value="登录" class="sub">
        </form>
        </form>
        <form method="post" action="login.php">
    </div>
</div>
</body>
</html>

<?php
session_start();
//1. 获取到用户提交的验证码
$captcha = $_POST["captcha"];
//2. 将session中的验证码和用户提交的验证码进行核对,当成功时提示验证码正确，并销毁之前的session值,不成功则重新提交
if (strtolower($_SESSION["captcha"]) == strtolower($captcha)) {
    echo "验证码正确!";
    $_SESSION["captcha"] = "";
} else {
    echo "<script>alert('验证码错误');location.href='reg.php';</script>";
}


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
//注册
$name = $_POST['username'];
$pwd = $_POST['password'];
$pwd2 = $_POST['password2'];
SafeFilter($name);
SafeFilter($pwd);
SafeFilter($pwd2);

if ($pwd != $pwd2) {
    echo "<script>alert('两次输入的密码不同');location.href='reg.php';</script>";

}
if (strlen($pwd) < 6) {
    echo "<script>alert('输入的密码过短');location.href='reg.php';</script>";
}
require_once('conn.php');
$con = mysqli_connect("127.0.0.1", "root", "root");
mysqli_select_db($con, "test");
$sql_show = "select * from admin where username = '$name'";
$res = mysqli_query($con, $sql_show);
if ($res) {
    if (mysqli_num_rows($result) >= 1) {
        echo "<script>alert('用户已存在，请重新注册');location.href='reg.php';</script>";
    } else {
        $sql1 = "insert into admin(username, password) values ('$name', '$pwd')";
        $result = mysqli_query($con, $sql1);
        if ($result) {
            echo "<script>alert('注册成功');location.href='message.php';</script>";
        } else {
            echo "<script>alert('注册失败');location.href='reg.php';</script>";
        }
    }
}

?>