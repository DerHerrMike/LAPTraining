<?php
$page_name = "Product Management Admin";
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
?>

    <div class="content">
        <br><br>
        <article>
            <h2>Product Management Admin</h2>
        </article>
    </div>

    <div class="container">
        <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 10px;">
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image File Name</th>
                <th>Price</th>
                <th>Manage</th>
            </tr>

            <?php
            $product = new Product();
            $product->getProductsAdmin();
            ?>
        </table>
        <br><br>
    </div>

<?php
if(isset($_POST['deletebtn'])){
    $id = $_POST['product_id'];
    $product = new Product();
    $product->deleteProduct($id);
}
?>



<?php include __DIR__ . '/inc/footer.php'; ?>