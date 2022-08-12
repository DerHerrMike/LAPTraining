<?php
$page_name = 'Admin Panel';
include __DIR__ . '/inc/header.php';
if(!isset($_SESSION['logged_in'])){
    die('You must be logged in to view this page!');
}
if($_SESSION['user_role'] != 1){
    die('You do not have permission to view this page!');
}
include_once __DIR__ . '/classes/userClass.php';

?>

<div class="content">
    <br><br>
    <article>
        <h2>Admin panel</h2>
    </article>
</div>

<div class="container">
    <img class="image_medium" src="img/admin.jpg">
</div>

