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

<!DOCTYPE html>
<html>
<head>
    <meta charset="gbk">
    <title>留言板</title>
</head>
<body>
<div id="bdy">
    <div id="top">留言板</div>
    <a href="login.php" class="a">登录</a>
    <a href="reg.php" class="a">注册</a>
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
                        echo "?目前数据表中还没有任何留言!";
                    } else {
                        $totalnum = mysqli_num_rows($result); //获取数据库中所有数据条数
                        $pagesize = 10;//每页显示10条
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
                        //输出分页信息
                        echo "<table border=0 width=95%><tr><td>";
                        $datanum = mysqli_num_rows($result);
                        echo "<br>";
                        //从message表中查询当前页面所要显示的留言，并根据时间排序
                        //echo $page . " " . $begin . " " . $pagesize . "<br>";
                        $sql1 = "select * from message order by addtime desc limit $begin, $pagesize";
                        $result = mysqli_query($con, $sql1);
                        $datanum1 = mysqli_num_rows($result);
                        //循环输出所有留言，如果管理员已经回复则同时输出回复
                        for ($i = 0; $i < $datanum1; $i++) {//$datanum???
                            $info = mysqli_fetch_array($result);
                            echo "[" . $info['author'] . "]于" . $info['addtime'] . "留言:<br>";
                            echo "标题：" . $info['title'] . "<br>";
                            echo "内容：" . $info['content'] . "<br>";
                            echo "<hr>";
                        }//else结束
                        echo "</td></tr></table>";
                        echo "共有" . $totalnum . "条留言，每页" . $pagesize . "条，共" . $totalpage . "页。<br>";
                        //输出页码
                        for ($i = 0; $i < $totalpage; $i++) {
                            echo "<a href=message.php?page=" . ($i + 1) . ">[" . ($i + 1) . "]</a>";
                        }

                    }
                    ?>
                </td>
            </tr>
            <a href="addmessage.php" class="a">添加留言</a><br>
            <a href="delmessage.php" class="a">删除留言</a><br>
        </table>
    </div>
    <a href="logout.php" class="a">退出</a><br>
</div>
</body>
</html>