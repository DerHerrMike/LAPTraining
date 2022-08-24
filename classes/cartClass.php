<?php
include_once __DIR__ . '/../inc/dbconnect.php';

class Cart extends Connection
{

    public function addProductToCart($product_id, $user_id, $price)
    {


        $sql = "SELECT * FROM laptraining.cart WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        if ($stmt->rowCount() < 1) {
            self::createCart($user_id);
        } else {
            $sql = "SELECT * FROM laptraining.cart WHERE user_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($user_id);
            $result = $stmt->fetch();
            $cart_id = $result['id'];
            self::createCartItem($cart_id, $product_id, $price);
        }


    }

    public function createCart($user_id)
    {

        $created_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO laptraining.cart (user_id, created) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $created_at]);
    }

    public function createCartItem($cart_id, $product_id, $quantity, $price)
    {
        $sql = "INSERT INTO laptraining.cart_item (cart_id, product_id, quantity, price) VALUES (?,?,?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id, $product_id, $quantity, $price]);
        echo "CartItem created";
    }

    public function getCart($user_id){
        $sql = "SELECT * FROM laptraining.cart WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

}