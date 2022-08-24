<?php
$page_name = "Shopping cart";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
$product_id = $_GET['product_id'];
$user_id = $_GET['user_id'];
?>

    <div class="content">
        <br><br>
        <article>
            <h2>Shopping Cart Overview Customer</h2>
        </article>
    </div>

<?php
echo '
    <br><br>
    <div class="content">
    <h4>Product ID:' . $product_id . '</h4>
    <br><br>
    <h4>User ID:' . $user_id . '</h4>
    <br><br>
   
    </div>
    ';

include __DIR__ . '/inc/footer.php'; ?>