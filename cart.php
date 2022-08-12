<?php
$page_name = "Shopping cart";
include __DIR__ . '/inc/header.php';
if(!isset($_SESSION['logged_in'])){
    die('You must be logged in to view this page!');
}
?>

    <div class="content">
        <br><br>
        <article>
            <h2>Shopping Cart Overview Customer</h2>
        </article>
    </div>

<?php
include __DIR__ . '/inc/footer.php'; ?>