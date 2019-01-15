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
                if (!get_magic_quotes_gpc())  //����magic_quotes_gpcת������ַ�ʹ��addslashes(),����˫��ת�塣
                {
                    $value = addslashes($value); //�������ţ�'����˫���ţ�"������б�ߣ�\���� NUL��NULL �ַ���  ���Ϸ�б��ת��
                }
                $value = preg_replace($ra, '', $value);     //ɾ���Ǵ�ӡ�ַ����ֱ�ʽ����xss�����ַ���
                $arr[$key] = htmlentities(strip_tags($value)); //ȥ�� HTML �� PHP ��ǲ�ת��Ϊ HTML ʵ��
            } else {
                SafeFilter($arr[$key]);
            }
        }
    }
}//php��ע���XSS����ͨ�ù���
require_once('conn.php');
session_start();
//1. ��ȡ���û��ύ����֤��
$captcha = $_POST["captcha"];
//2. ��session�е���֤����û��ύ����֤����к˶�,���ɹ�ʱ��ʾ��֤����ȷ��������֮ǰ��sessionֵ,���ɹ��������ύ
if (strtolower($_SESSION["captcha"]) == strtolower($captcha)) {
    echo "��֤����ȷ!";
    $_SESSION["captcha"] = "";
} else {
    //echo $_SESSION["captcha"];
    echo "<script>alert('��֤�����');location.href='login.php';</script>";
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
            echo "<script>alert('�������');location.href='login.php';</script>";
        } else {
            setcookie("user", "true", 0);
            setcookie("username", "$name", 0);
            echo "<script>alert('�û�����������ȷ');location.href='message.php';</script>";
        }
    } else {
        echo "<script>alert('�û������ڣ���ע��');location.href='reg.php';</script>";
    }
}