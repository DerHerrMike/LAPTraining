<?php
$page_name = "Products Customer View";
include __DIR__ . '/inc/header.php';
if(!isset($_SESSION['logged_in'])){
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

<?php include __DIR__ . '/inc/footer.php'; ?>