<?php

use function PHPSTORM_META\type;

include_once "functions.php";

$menu = getMenuType("header");
?>
<header class = "container main-header">
    <div class="logo-holder">
    <a href="<?php echo isset($menu['name']['path']) ? $menu['name']['path'] : '#'; ?>">
      <img alt="img" src="img/logo.png" height="40">
    </a>
    </div>
    <nav class="main-nav">
      <ul class="main-menu" id="main-menu container">
        <?php printMenu($menu); ?>
      </ul>
      <a class="hamburger" id="hamburger">
        <i class="fa fa-bars"></i>
      </a>
    </nav>
</header> 
?>