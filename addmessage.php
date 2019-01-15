<?php
if (!isset($_COOKIE['user'])) {
    echo "<script>alert('未登录');location.href='login.php';</script>";
} else if ($_COOKIE['user'] == "null") {
    echo "<script>alert('未登录');location.href='login.php';</script>";
}
if (!isset($_COOKIE['username'])) {
    echo "<script>alert('未登录');location.href='login.php';</script>";
}
if (!isset($_COOKIE['username']) == "null") {
    echo "<script>alert('未登录');location.href='login.php';</script>";
}
?>

<head>
    <meta charset="gbk">
    <title>留言板添加留言</title>
</head>
<div id="left">
    <h5>写留言</h5>
    <form method="post" action="add.php">
        标题：<input type="text" placeholder="请输入标题" name="title">
        </br></br>
        内容：<textarea cols="40" rows="5" placeholder="留言请不要超过140字" name="content"></textarea>
        </br></br>
        <input type="submit" value="添加留言" id="sub">
    </form>
    <a href="logout.php" class="a">退出</a><br>
</div>

