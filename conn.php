<?php
$con = mysqli_connect("localhost","root","root");
if (!$con)
{
    die('Could not connect: ' . mysqli_error());
}
mysqli_close($con);
?>