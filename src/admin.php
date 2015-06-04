<?php
    if ($admin) {
        if (isset($_GET['subp'])) {
            $page = "admin/" . $_GET['subp'] . ".php";
            if (file_exists($page))
                require $page;
            else
                require "404.php";
        } elseif (isset($_GET['act'])) {
            $page = "admin/action/" . $_GET['act'] . ".php";
            if (file_exists($page))
                require $page;
            else
                require "404.php";
        } else {
?>
<p><a href="?p=admin&subp=register">Register a new member</a></p>
<!--<p><a href="?p=admin&subp=edituser">Edit some user's information</a></p>-->
<?php
        }
    } else {
        require "403.php";
    }
?>