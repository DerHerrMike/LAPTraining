<?php
$page_name = "Single Product Details";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}

include_once __DIR__ . '/classes/productClass.php';
$product_id = $_GET['pid'];
$user_id = $_SESSION['user_id'];
$product = new Product();
?>

    <div class="content">
        <br><br>
        <article>
            <h2>Product Details</h2>
        </article>
    </div>

    <div class="container">

        <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 2px;">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>


            <?php
            $product->getAProduct($product_id, $user_id);
            ?>
        </table>
    <br><br>
    <form method="post" action="#">
        <div class="container_small">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity">
            <button type="submit" name="add">add to cart</button>
        </div>
    </form>
    </div>
<?php
if (isset($_POST['add'])) {
    echo $_POST['quantity'];
    include_once __DIR__ . '/classes/cartClass.php';
    $quantity = $_POST['quantity'];
    $cart = new Cart();
    $getCart = $cart->getCart();
    if ($getCart != NULL) {
        $cart_id = $getCart(['id']);
    } else {
        $cart->createCart($user_id);
        $cart_id = $cart->getCart();
    }
    $cart->createCartItem($cart_id, $product_id, $quantity, $price);

    include __DIR__ . '/inc/footer.php';

}
