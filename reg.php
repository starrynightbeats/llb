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
            �û��� <input type="text" placeholder="�������û���" name="username">
            <br><br>
            ���� <input type="password" placeholder="����������" name="password">
            <br>���볤�Ȳ�������λ<br>
            ȷ������<input type="password" placeholder="���ٴ���������" name="password2">
            <br><br>
            ��֤��
            <img src="image.php" onclick="this.src='image.php?'+new Date().getTime();" width="80" height="48"><br/>
            <input type="text" name="captcha" placeholder="������ͼƬ�е���֤��"><br/>
            <input type="submit" value="ע��" class="sub">
        </form>
        <form method="post" action="login.php">
            <input type="submit" value="��¼" class="sub">
        </form>
    </div>
</div>
</body>
</html>