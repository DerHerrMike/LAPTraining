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

    public function orderCart($id)
    {

        $ordered_at = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM laptraining.cart WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if ($stmt->rowCount() == 1) {
            $sql = "UPDATE laptraining.cart SET ordered = ? WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$ordered_at, $id]);
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
        $sql = "SELECT * FROM laptraining.cart_item WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id, $product_id]);
        $result = $stmt->fetch();
        if ($stmt->rowCount() == 1) {
            $sql = "UPDATE laptraining.cart_item SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$quantity, $cart_id, $product_id]);
            echo "quantity updated";
        } else {
            $sql = "INSERT INTO laptraining.cart_item (cart_id, product_id, quantity, price) VALUES (?,?,?,?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$cart_id, $product_id, $quantity, $price]);
            echo "CartItem created";
        }


    }

    public function getCartID($user_id)
    {
        $sql = "SELECT * FROM laptraining.cart WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        if ($stmt->rowCount() == 1) {
            if (!empty ($result['ordered'])) {
                return null;
            }
        } else {
            return $result['id'];
        }
        return $result['id'];
    }


    public function getCartDetails($cart_id)
    {
        $sql = "SELECT * FROM laptraining.cart WHERE id =?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cart_id]);
        $result = $stmt->fetch();


    }

}