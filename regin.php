<!DOCTYPE html>
<html>
<head>
    <meta charset="gbk">
    <title>���԰��û�ע��</title>
</head>
<body>
<div id="div">
    <h3>���԰��û�ע��</h3>
    <div id="cnt">
        <form method="post" action="regin.php">
            �û���<input type="text" placeholder="�������û���" name="username">
            <br><br>
            ����<input type="password" placeholder="����������" name="password">
            <br><br>
            ȷ������<input type="password" placeholder="���ٴ���������" name="password2">
            <br><br>
            ע������<input type="text" placeholder="������ע������" name="email">
            <br><br>
            ��֤��
            <img src="image.php" onclick="this.src='image.php?'+new Date().getTime();" width="80" height="48"><br/>
            <input type="text" name="captcha" placeholder="������ͼƬ�е���֤��"><br/>
            <input type="submit" value="��¼" class="sub">
        </form>
        </form>
        <form method="post" action="login.php">
    </div>
</div>
</body>
</html>

<?php
session_start();
//1. ��ȡ���û��ύ����֤��
$captcha = $_POST["captcha"];
//2. ��session�е���֤����û��ύ����֤����к˶�,���ɹ�ʱ��ʾ��֤����ȷ��������֮ǰ��sessionֵ,���ɹ��������ύ
if (strtolower($_SESSION["captcha"]) == strtolower($captcha)) {
    echo "��֤����ȷ!";
    $_SESSION["captcha"] = "";
} else {
    echo "<script>alert('��֤�����');location.href='reg.php';</script>";
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
//ע��
$name = $_POST['username'];
$pwd = $_POST['password'];
$pwd2 = $_POST['password2'];
SafeFilter($name);
SafeFilter($pwd);
SafeFilter($pwd2);

if ($pwd != $pwd2) {
    echo "<script>alert('������������벻ͬ');location.href='reg.php';</script>";

}
if (strlen($pwd) < 6) {
    echo "<script>alert('������������');location.href='reg.php';</script>";
}
require_once('conn.php');
$con = mysqli_connect("127.0.0.1", "root", "root");
mysqli_select_db($con, "test");
$sql_show = "select * from admin where username = '$name'";
$res = mysqli_query($con, $sql_show);
if ($res) {
    if (mysqli_num_rows($result) >= 1) {
        echo "<script>alert('�û��Ѵ��ڣ�������ע��');location.href='reg.php';</script>";
    } else {
        $sql1 = "insert into admin(username, password) values ('$name', '$pwd')";
        $result = mysqli_query($con, $sql1);
        if ($result) {
            echo "<script>alert('ע��ɹ�');location.href='message.php';</script>";
        } else {
            echo "<script>alert('ע��ʧ��');location.href='reg.php';</script>";
        }
    }
}

?>