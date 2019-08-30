<?php
unset($_SESSION["Yonetici"]);
session_destroy();
yonlendir("index.php");