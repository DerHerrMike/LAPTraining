<?php
$page_name = "Products Customer View";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}

include_once __DIR__ . '/classes/productClass.php';


?>

    <div class="content">
        <br><br>
        <article>
            <h2>Product View</h2>
        </article>
    </div>

    <div class="productcontent">
        <?php
        $product = new Product();
        $product->loadAllProducts();
        ?>
    </div>

<?php
if (isset($_POST['add'])) {
    include_once __DIR__ . '/classes/cartClass.php';
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $cart = new Cart();
    $cart->addProductToCart($product_id, $user_id, $price);


}


include __DIR__ . '/inc/footer.php'; ?>