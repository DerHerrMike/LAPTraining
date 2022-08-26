<?php
$page_name = "Shopping cart";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
include_once __DIR__ . '/classes/CartItemClass.php';
$product_id = $_GET['product_id'];
$user_id = $_GET['user_id'];
$cart_id = $_GET['cart_id'];
$product = new Product();


?>

    <div class="content">
        <br><br>
        <article>
            <h2>Shopping Cart Overview Customer</h2>
        </article>
    </div>
    <br><br>

    <div class="container">
        <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 10px;">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price / unit</th>
                <th>Total</th>
            </tr>


                        <?php
            $cartItem = new CartItem();
            $cartItem->displayCartItems($cart_id);
            ?>
        </table>
    </div>
<br><br>

<div class="container_small">
    <form method="post" action="purchase.php?cart_id=<?php echo $cart_id; ?>">
        <button type="submit" name="order">buy now!</button>
    </form>
</div>
<br><br>

<?php



include __DIR__ . '/inc/footer.php'; ?>