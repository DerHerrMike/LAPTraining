<?php
include_once __DIR__ . '/../inc/dbconnect.php';
include_once __DIR__ . '/../classes/productClass.php';

class CartItem extends Connection{

    public function getCartItems($cart_id){

        $product = new Product();
        $totalQuantity = 0;
        $totalPrice = 0;

        $sql = "SELECT * FROM laptraining.cart_item WHERE cart_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id]);

        while($result = $stmt->fetch()) {
            $product_id = $result['product_id'];
            $name = $product->getProductName($product_id);
            $price = $result['price'];
            $quantity = $result['quantity'];
            $totalQuantity = $totalQuantity+$quantity;
            $totalPrice = $totalPrice+$price;

            echo '
        <tr>
            <td> ' . $name . '</td>
            <td>' . $price. '</td>
            <td>' . $quantity . '</td>
        </tr>
        ';
        }
        echo '<tr>
                <td> Total: </td>
                <td>' . $totalPrice . '</td>
                <td>'. $totalQuantity. '</td>

';

    }
}
