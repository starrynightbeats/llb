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
$time = date("Y-m-d h:i:s");//�õ�����
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
    echo "<script>alert('���Գɹ�');location.href='message.php';</script>";
} else {
    echo "<script>alert('����ʧ��');location.href='reg.php';</script>";
}