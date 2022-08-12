<?php
include __DIR__ . '/../inc/dbconnect.php';

class Product extends Connection
{

    public function loadAllProducts()
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while ($product = $stmt->fetch()) {
            echo '
        <div class="productThumb">
       <h4>' . $product['name'] . '</h4>
       <img class="image" src="img/' . $product['image'] . '">
       <p>' . $product['price'] . " Euro" . '</p>
        </div>  
        ';
        }
    }

    public function getProductsAdmin()
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while ($product = $stmt->fetch()) {
            echo "
            <tr>
            <td>" . $product['id'] . "</td>
            <td>" . $product['name'] . "</td>
            <td>" . $product['description'] . "</td>
            <td>" . $product['image'] . "</td>
            <td>" . $product['price'] . "</td>
            <td><a href='productProfile.php?pid=" . $product['id'] . "'>Edit</a></td>
            </tr>
            ";
        }
    }

    public function deleteProduct($product_id)
    {
        $sql = "DELETE FROM product WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);

        echo 'Product deleted successfully!';
        header('Refresh=2; url=admin_panel.php');
    }

    /**
     * @throws Exception
     */
    public function getOneProduct($product_id)
    {
        $sql = "SELECT * FROM product WHERE id  = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        if ($stmt->rowCount() == 1) {
            echo "
            <tr>
                <td><input type=\"text\" name=\"name\" placeholder=\"" . $result['name'] . "\"></td>
                <td><input type=\"text\" name=\"description\" placeholder=\"" . $result['description'] . "\"></td>
                <td><input type=\"text\" name=\"image\" placeholder=\"" . $result['image'] . "\"></td>
                <td><input type=\"text\" name=\"price\" placeholder=\"" . $result['price'] . "\"></td>         
            </tr>
            ";
        } else {
            throw new Exception("Product not found.");

        }
    }

    public function getAProduct($product_id)
    {
        $sql = "SELECT * FROM product WHERE id  = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        return $result;
    }

    /**
     * @throws Exception
     */
    public function updateProduct($product_id, $product_name, $product_description, $product_image, $product_price){
        $sql = "
        UPDATE product SET name = ?, description = ?, image = ?, price = ? WHERE id =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_name, $product_description, $product_image, $product_price, $product_id ]);
        $result = $stmt ->fetch();
        if ($stmt->rowCount() == 1) {
            echo'Product updated';
        }else   {
            throw new Exception("Product not found.");
        }
    }
}