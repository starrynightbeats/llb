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
session_start();
if (isset($_GET['time'])) {
    $time = $_GET['time'];
} else {
    echo "<script>alert('ɾ������ʧ��!!');location.href='delmessage.php';</script>";
}
unset($_GET['time']);

$con = mysqli_connect("127.0.0.1", "root", "root");
mysqli_select_db($con, "test");
$sql = "DELETE from message where addtime = '$time'";
$res = mysqli_query($con, $sql);

if ($res) {
    echo "<script>alert('ɾ�����Գɹ�');location.href='message.php';</script>";
} else {
    echo "<script>alert('ɾ������ʧ��');location.href='delmessage.php';</script>";
}

