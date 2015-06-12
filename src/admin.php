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
<div class="title"><?php echo $lang['administration_title']; ?></div>
<div class="page-content">
    <p><a href="?p=admin&subp=register"><button><?php echo $lang['register_member'] ?></button></a></p>
    <p><a href="?p=admin&subp=edit"><button><?php echo $lang['edit_member'] ?></button></a></p>
    <p><a href="?p=admin&subp=name"><button><?php echo $lang['change_member_name'] ?></button></a></p>
</div>
<?php
        }
    } else {
        require "403.php";
    }
?>