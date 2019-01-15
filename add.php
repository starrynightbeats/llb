<?php
session_start();
require_once('conn.php');
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
$title = $_POST['title'];
SafeFilter($title);
$content = $_POST['content'];
SafeFilter($content);
$title = $_POST['title'];
$content = $_POST['content'];

// store session data
if (isset($_COOKIE['username'])) {
    $name = $_COOKIE['username'];
} else {
    $name = "null";
}
$time = date("Y-m-d h:i:s");//得到日期
$sql = "INSERT INTO message (author, addtime, title,content) VALUES ('$name', '$time', '$title', '$content')";
/**
 * Created by PhpStorm.
 * User: a1817
 * Date: 2018/10/31
 * Time: 18:51
 */
$con = mysqli_connect("127.0.0.1", "root", "root");
mysqli_select_db($con, "test");
$res = mysqli_query($con, $sql);

if ($res) {
    echo "<script>alert('留言成功');location.href='message.php';</script>";
} else {
    echo "<script>alert('留言失败');location.href='reg.php';</script>";
}