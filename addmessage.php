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

<head>
    <meta charset="gbk">
    <title>���԰��������</title>
</head>
<div id="left">
    <h5>д����</h5>
    <form method="post" action="add.php">
        ���⣺<input type="text" placeholder="���������" name="title">
        </br></br>
        ���ݣ�<textarea cols="40" rows="5" placeholder="�����벻Ҫ����140��" name="content"></textarea>
        </br></br>
        <input type="submit" value="�������" id="sub">
    </form>
    <a href="logout.php" class="a">�˳�</a><br>
</div>

