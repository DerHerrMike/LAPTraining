<?php
$page_name = 'Add Product';
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
if ($_SESSION['user_role'] != 1) {
    die('You do not have permission to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';
?>

    <div class="content">
        <br><br>
        <article>
            <h2>Add New Product</h2>
        </article>
    </div>

    <div class="content">
        <form action='#' method='post' enctype="multipart/form-data">
            <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 10px;">
                <tr>
                    <th>Name</th>
                </tr>
                <tr>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <th>Description</th>
                </tr>
                <tr>
                    <td><input type="text" name="description"></td>
                </tr>
                <tr>
                    <th>Image File Name</th>
                </tr>
                <tr>
                    <td><input type="file" name="fileToUpload"></td>
                </tr>
                <tr>
                    <th>Price</th>
                </tr>
                <tr>
                    <td><input type="text" name="price"></td>
                </tr>
                <tr>
                    <th>Status</th>
                </tr>
                <tr>
                    <td><input type="text" name="status"></td>
                </tr>
            </table>
            <div class="productcontent">
                <button type='submit' class='add' name='add_product'>Add Product</button>
            </div>
        </form>
        <br><br>
    </div>
<?php
$product = new Product();
if (isset($_POST['add_product'])) {
    try {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $file = $_FILES["fileToUpload"]["name"];
        $product->uploadProductImage();
    } catch (Exception $e) {
        print_r($e);
        exit(1);
    }

    try {
        $product->createProduct($_POST,$file);
    } catch (Exception $e) {
        print_r($e);
        die();
    }

}