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
            if ($product['status'] == 1) {
                echo '
       <div class="productThumb">
       <form action="product.php?product_id=' . $product['id'] . '" method="post">
        <h4>' . $product['name'] . '</h4>
        <img class="image" src="img/' . $product['image'] . '">
        <p>' . $product['price'] . " Euro" . '</p>
        <input type="hidden" name="price" value="' . $product['price'] . '">
        <button type="submit" name="details">details</button>
        </form>
       </div>  
        ';
            } else {
                return;
            }
        }
    }

    public function getProducts()
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while ($product = $stmt->fetch()) {
            if ($product['status'] == 1) {
                echo "
            <tr>
            <td>" . $product['name'] . "</td>
            <td><img class='image' src='img/" . $product['image'] . "'></td>
            <td>" . $product['price'] . "</td>
            <td><a href='product.php?pid=" . $product['id'] . "'>see more</a></td>
            </tr>
            ";
            }
        }
    }

    public function getProductsAdmin()
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while ($product = $stmt->fetch()) {
            if ($product['status'] == 1) {
                $active = 'active';
            } else {
                $active = 'inactive';
            };
            echo "
            <tr>
            <td>" . $product['id'] . "</td>
            <td>" . $product['name'] . "</td>
            <td>" . $product['description'] . "</td>
            <td>" . $product['image'] . "</td>
            <td>" . $product['price'] . "</td>
            <td>" . $active . "</td>
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
            if ($result['status'] == 1) {
                $updateStatus = 'deactivate';
            } else {
                $updateStatus = 'activate';
            }
            echo "
            <tr>
                <td><input type=\"text\" name=\"name\" placeholder=\"" . $result['name'] . "\"></td>
                <td><input type=\"text\" name=\"description\" placeholder=\"" . $result['description'] . "\"></td>
                <td><input type=\"text\" name=\"image\" placeholder=\"" . $result['image'] . "\"></td>
                <td><input type=\"text\" name=\"price\" placeholder=\"" . $result['price'] . "\"></td>
                <td><div class='productcontent'>
                <button type='submit' name='status'>$updateStatus</button></div>      
            </tr>
            ";
        } else {
            throw new Exception("Product not found.");

        }
    }

    public function getAProduct($product_id)
    {
        $sql = "SELECT * FROM laptraining.product WHERE id  = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();

        echo '
        <tr>
        <td> ' . $result['name'] . '</td>
        <td> ' . $result['description'] . '</td>
        
        <td> <img class="image" src="img/' . $result['image'] . '"></td>
        <td> EUR ' . $result['price'] . '</td>
        <td><form method="post" action="#">
         <input type="number" name="quantity">
            <button type="submit" name="add">add to cart</button>
        </td>
        </tr>
        ';

    }

    public function getProductPrice($product_id){
        $sql = "SELECT * FROM laptraining.product WHERE id  =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        $price = $result['price'];
        return $price;

    }

    public function getProductName($product_id) {
        $sql = "SELECT * FROM laptraining.product WHERE id  =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        $name = $result['name'];
        return $name;
    }

    /**
     * @throws Exception
     */
    public function createSql($editFields)
    {
        $id = $editFields['pid'];
        $sqlStart = "UPDATE product SET";

        $updateValues = array();
        foreach ($editFields as $key => $value) {
            if (!empty($value) and ($key !== 'pid')) {
                $updateValues[$key] = $value;
            }
        }

        $selectKeys = array();
        foreach ($editFields as $key => $value) {
            if (!empty($value) and ($key !== 'pid')) {
                $selectKeys[$key] = $key;
            }
        }

        $sqlFields = $sqlStart . ' ' . implode(' = ?, ', $selectKeys) . ' = ?';
        $sqlFinal = $sqlFields . ' WHERE id = ?';
        self::updateProduct($id, $sqlFinal, $updateValues);


    }

    /**
     * @throws Exception
     */
    public function updateProduct($product_id, $sql, $fields)
    {
        $array = array();
        foreach ($fields as $field) {
            array_push($array, $field);
        }

        array_push($array, $product_id);
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($array);
        $result = $stmt->fetch();
        if ($stmt->rowCount() == 1) {
            echo 'Product updated';
        } else {
            throw new Exception("Product not found.");
        }
    }

    public function updateStatus($product_id)
    {
        $sql = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        print $result['status'];
        if ($result['status'] == 1) {
            $sql = "UPDATE product SET status = 0 WHERE id = ?";

        } else {
            $sql = "UPDATE product SET status = 1 WHERE id = ?";
        }
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        echo 'Product status updated!';

    }

    public function productActive($product_id)
    {
        $sql = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result['active'] == 1) {
            echo 'Product active';
        } else {
            echo 'Product not active';
        }


    }
}