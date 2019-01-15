<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>留言板用户登录</title>

</head>
<body>
<div id="div">
    <h3>留言板用户登录</h3>
    <div id="cnt">
        <form method="post" action="loginn.php">
            用户名<input type="text" placeholder="请输入用户名" name="username">
            <br><br>
            密码<input type="password" placeholder="请输入密码" name="password">
            <br><br>
            验证码<img src="image.php" onclick="this.src='image.php?'+new Date().getTime();" width="80" height="48"><br/>
            <input type="text" name="captcha" placeholder="请输入图片中的验证码"><br/>
            <input type="reset" value="重置" class="sub"> <input type="submit" value="登录" class="sub">
        </form>
        <form method="post" action="reg.php">
            <input type="submit" value="注册" class="sub">
        </form>
    </div>
</div>
</body>
</html>