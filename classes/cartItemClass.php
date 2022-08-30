<?php
include_once __DIR__ . '/../inc/dbconnect.php';


class CartItem extends Connection
{

    public function displayCartItems($cart_id)
    {

        $product = new Product();
        $totalQuantity = 0;
        $totalPrice = 0;
        $grandTotal = 0;

        $sql = "SELECT * FROM laptraining.cart_item WHERE cart_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id]);

        while ($result = $stmt->fetch()) {
            $product_id = $result['product_id'];
            $name = $product->getProductName($product_id);
            $price = $result['price'];
            $quantity = $result['quantity'];
            $totalQuantity = $totalQuantity + $quantity;
            $totalPrice = $price * $quantity;
            $grandTotal = $grandTotal+$totalPrice;

            echo '
        <tr>
            <td> ' . $name . '</td>
            <td>' . $quantity . '</td>
            <td>' . $price . '</td>
            <td>' . $totalPrice . '</td>
        </tr>
        ';
        }
        echo '<tr>
                <td> Grand Total: </td>
                <td>' . $totalQuantity . '</td>
                <td> n.a. </td>
                <td>' . $grandTotal . '</td>

';

    }

    public function getOrderItems($cart_id): array
    {
        include_once __DIR__ . '/../classes/productClass.php';
        $product = new Product();
        $fullOrder = array(); // array for all order items

        $sql = "SELECT * FROM laptraining.cart_item WHERE cart_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id]);
        $result = $stmt->fetchAll();


        foreach($result as $prod) {
            $orderItem = array();   //individual order item array
            $product_id = $prod['product_id'];
            $name = $product->getProductName($product_id);
            $price = $prod['price'];
            $quantity = $prod['quantity'];
            $orderItem[] = $name;
            $orderItem[] = $price;
            $orderItem[] = $quantity;
            array_push($fullOrder, $orderItem);
        }

        return $fullOrder;
    }

    public function getOrderTotalPrice($cart_id)
    {

        $product = new Product();
        $totalPriceItems = 0;
        $orderItemPrice = array();   //individual order item array

        $sql = "SELECT * FROM laptraining.cart_item WHERE cart_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id]);

        while ($result = $stmt->fetch()) {

            $price = $result['price'];
            $quantity = $result['quantity'];
            $totalPriceItems = $price * $quantity;

            array_push($orderItemPrice, $quantity, $totalPriceItems);
        }

    }
}
