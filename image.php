<?php
/**
 * ��ĸ+���ֵ���֤������
 */
// ����session
session_start();
//1.������ɫ����
$image = imagecreatetruecolor(100, 30);

//2.Ϊ��������(����)��ɫ
$bgcolor = imagecolorallocate($image, 255, 255, 255);

//3.�����ɫ
imagefill($image, 0, 0, $bgcolor);

// 4.������֤������

//4.1 ������֤�������
$content = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

//4.1 ����һ�������洢��������֤�����ݣ������û��ύ�˶�
$captcha = "";
for ($i = 0; $i < 4; $i++) {
    // �����С
    $fontsize = 10;
    // ������ɫ
    $fontcolor = imagecolorallocate($image, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
    // ������������
    $fontcontent = substr($content, mt_rand(0, strlen($content)), 1);
    $captcha .= $fontcontent;
    // ��ʾ������
    $x = ($i * 100 / 4) + mt_rand(5, 10);
    $y = mt_rand(5, 10);
    // ������ݵ�������
    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
}
$_SESSION["captcha"] = $captcha;

//4.3 ���ñ�������Ԫ��
for ($$i = 0; $i < 200; $i++) {
    $pointcolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
    imagesetpixel($image, mt_rand(1, 99), mt_rand(1, 29), $pointcolor);
}

//4.4 ���ø�����
for ($i = 0; $i < 3; $i++) {
    $linecolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
    imageline($image, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $linecolor);
}

//5.����������ͼƬͷ��Ϣ
header('content-type:image/png');

//6.���ͼƬ�������
imagepng($image);

//7.����ͼƬ
imagedestroy($image);