<?php
if (!isset($_COOKIE['user'])) {
    echo "<script>alert('δ��¼');location.href='login.php';</script>";
} else if ($_COOKIE['user'] == "null") {
    echo "<script>alert('δ��¼');location.href='login.php';</script>";
}
if (!isset($_COOKIE['username'])) {
    echo "<script>alert('δ��¼');location.href='login.php';</script>";
}
if (!isset($_COOKIE['username']) == "null") {
    echo "<script>alert('δ��¼');location.href='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="gbk">
    <title>���԰�</title>
</head>
<body>
<div id="bdy">
    <div id="top">���԰�</div>
    <a href="login.php" class="a">��¼</a>
    <a href="reg.php" class="a">ע��</a>
    <div id="right">
        <table cellspacing="0" cellpadding="0" border="1">
            <tr>
                <td height=200>
                    <?php
                    $con = mysqli_connect("127.0.0.1", "root", "root");
                    mysqli_select_db($con, "test");
                    $sql = "select * from message";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) < 1) {
                        echo "?Ŀǰ���ݱ��л�û���κ�����!";
                    } else {
                        $totalnum = mysqli_num_rows($result); //��ȡ���ݿ���������������
                        $pagesize = 10;//ÿҳ��ʾ10��
                        if (!isset($_GET["page"])) {
                            $page = 1;
                            //echo "not set -- page = " . $page . "<br>";
                        } else {
                            $page = $_GET["page"];
                            //echo "page = " . $page . "<br>";
                        }
                        if ($page == 0) {
                            $page = 1;
                        }
                        $begin = ($page - 1) * $pagesize;
                        $totalpage = ceil($totalnum / $pagesize);
                        //�����ҳ��Ϣ
                        echo "<table border=0 width=95%><tr><td>";
                        $datanum = mysqli_num_rows($result);
                        echo "<br>";
                        //��message���в�ѯ��ǰҳ����Ҫ��ʾ�����ԣ�������ʱ������
                        //echo $page . " " . $begin . " " . $pagesize . "<br>";
                        $sql1 = "select * from message order by addtime desc limit $begin, $pagesize";
                        $result = mysqli_query($con, $sql1);
                        $datanum1 = mysqli_num_rows($result);
                        //ѭ������������ԣ��������Ա�Ѿ��ظ���ͬʱ����ظ�
                        for ($i = 0; $i < $datanum1; $i++) {//$datanum???
                            $info = mysqli_fetch_array($result);
                            echo "[" . $info['author'] . "]��" . $info['addtime'] . "����:<br>";
                            echo "���⣺" . $info['title'] . "<br>";
                            echo "���ݣ�" . $info['content'] . "<br>";
                            echo "<hr>";
                        }//else����
                        echo "</td></tr></table>";
                        echo "����" . $totalnum . "�����ԣ�ÿҳ" . $pagesize . "������" . $totalpage . "ҳ��<br>";
                        //���ҳ��
                        for ($i = 0; $i < $totalpage; $i++) {
                            echo "<a href=message.php?page=" . ($i + 1) . ">[" . ($i + 1) . "]</a>";
                        }

                    }
                    ?>
                </td>
            </tr>
            <a href="addmessage.php" class="a">�������</a><br>
            <a href="delmessage.php" class="a">ɾ������</a><br>
        </table>
    </div>
    <a href="logout.php" class="a">�˳�</a><br>
</div>
</body>
</html>