<?php
include("vue/header.php");

$uc = empty($_GET['uc']) ? "home" : $_GET['uc'];

switch ($uc) {
    case 'home':
        require_once("controller/homeController.php");
        break;
    case 'post':
        require_once("controller/postController.php");
        break;
}

include("vue/footer.php");
