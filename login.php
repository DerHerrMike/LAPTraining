<?php
$page_name = 'Login';
include __DIR__ . '/inc/header.php';
?>

<div class="content">
    <form action="#" method="post">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="loginbtn">Login</button
    </form>

    <?php
    include 'classes/userClass.php';
    if (isset($_POST["loginbtn"])) {
        $user = new User();
        try {
            $user->userLogin($_POST["email"], sha1($_POST["password"]));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ?>
</div>
<?php include __DIR__ . '/inc/footer.php';