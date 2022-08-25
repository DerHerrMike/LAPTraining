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
$price = $product->getProductPrice($product_id);
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
            $result= $product->getAProduct($product_id);
            ?>
        </table>
    </div>
    <br><br>
    <!--<form method="post" action="#">
        <div class="container_small">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity">
            <button type="submit" name="awdd">add to cart</button>
        </div>
    </form>
    </div>-->
<?php
if (isset($_POST['add'])) {
    echo $_POST['quantity'];
    include_once __DIR__ . '/classes/cartClass.php';
    $quantity = $_POST['quantity'];
//    $name = $result(['name']);
    $cart = new Cart();
    $cart_id = $cart->getCartID($user_id);
    if ($cart_id == NULL) {
        $cart->createCart($user_id);
        $cart_id = $cart->getCartID($user_id);
    }
    $cart->createCartItem($cart_id, $product_id, $quantity, $price);
    header('Refresh: 2; url=cart.php?user_id=' . $user_id . '&cart_id=' . $cart_id . '&product_id=' . $product_id);
    include __DIR__ . '/inc/footer.php';

}
