<?php
unset($_SESSION["Kullanici"]);
session_destroy();
yonlendir("index.php");