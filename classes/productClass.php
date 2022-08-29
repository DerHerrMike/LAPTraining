<?php
include __DIR__ . '/../inc/dbconnect.php';

class Product extends Connection
{

    public function createProduct($product_data, $file)
    {

        $name = $product_data['name'];
        $description = $product_data['description'];
        $price = $product_data['price'];
        $status = $product_data['status'];


        $sql = "INSERT INTO laptraining.product (name, description, image, price, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$name, $description, $file, $price, $status]);
        echo "Product added successfully, you will be redirected shortly";
        header("Refresh: 1.5; url=products_admin.php");
    }

    public function uploadProductImage(){
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, this image file is too large.";
            $uploadOk = 0;
        }// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

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

    public function getProductPrice($product_id)
    {
        $sql = "SELECT * FROM laptraining.product WHERE id  =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$product_id]);
        $result = $stmt->fetch();
        $price = $result['price'];
        return $price;

    }

    public function getProductName($product_id)
    {
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