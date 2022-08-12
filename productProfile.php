<?php
$page_name = 'Product Profile';
include __DIR__ . '/inc/header.php';
if (!isset($_SESSION['logged_in'])) {
    die('You must be logged in to view this page!');
}
if ($_SESSION['user_role'] != 1) {
    die('You do not have permission to view this page!');
}
include_once __DIR__ . '/classes/productClass.php';

$id = $_GET['pid'];

echo 'product id="' . $id . '"';
?>

<div class="content">
    <br><br>
    <article>
        <h2>Product Profile</h2>
    </article>
</div>

<div class="content">
    <form action='#' method='post'>
        <input type='hidden' name='pid' value='<?php echo $id; ?>'>
    <table style="background: white; border: 1px solid #ccc; border-radius: 3px; padding: 10px;">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Image File Name</th>
            <th>Price</th>
        </tr>

        <?php
        $product = new Product();
        try {
            $product->getOneProduct($id);
        } catch (Exception $e) {
        }
        ?>
    </table>
        <div class="productcontent">
            <button type='submit' class='update' name='update'>Update</button>
            <button type='submit' class='delete' name='delete'>Delete</button>
        </div>
    </form>
    <br><br>
    <?php
    if (isset($_POST['delete'])) {
        try {
       $product->deleteProduct($_POST['pid']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    if (isset($_POST['update'])) {
        try {

            $returnedProduct = $product->getAProduct($_POST['pid']);
            if ($returnedProduct['name'] == $_POST['name']) {
                $_POST['name'] = $returnedProduct['name'];
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            try {
                $product->updateProduct($_POST['pid'], $_POST['name'], $_POST['description'], $_POST['image'], $_POST['price']);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    ?>
</div>
