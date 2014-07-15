<?php
if (isset($_GET['act'])) {
    $page = "action/" . $_GET['act'] . ".php";
    if (file_exists($page))
        include $page;
}
?>
<div class="title">Register</div>
<form id="register_form" name="register_form" method="post" action="?act=register">
    <p><input type="text" name="name" placeholder="Name" class="textbox" /></p>
    <p><input type="text" name="username" placeholder="Username" class="textbox" /></p>
    <p><input type="password" name="password" placeholder="Password" class="textbox" /></p>
    <br />
    <p><input type="submit" name="register" value="Register" class="button" /></p>
</form>