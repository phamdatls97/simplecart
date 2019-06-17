<?php
session_start();
require_once ('database.php');
$database = new Database();

if(isset($_POST) && !empty($_POST)){
    /**
     * Có giữ liệu đc gửi đi
     * Có tồn tại
     */
    if(isset($_POST['action'])){
        switch ($_POST['action']){
            case 'add':
                if(isset($_POST['quantity']) && isset($_POST['product_id'])){
                    $sql = "SELECT * FROM products WHERE id=".(int)$_POST['product_id'];
                    $product = $database -> runQuery($sql);
                    $product = current($product);
                    echo '<br> $product';
                    echo "<pre>";
                    print_r($product);
                    $product_id = $product['id'];
                    echo "</pre>";
                    if(isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])){
                        //True
                        if(isset($_SESSION['cart_item'][$product_id])){
                            $exist_cart_item = $_SESSION['cart_item'][$product_id];
                            $exist_quantity = $exist_cart_item['quantity'];
                            $cart_item = array();
                            $cart_item['id'] = $product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $exist_quantity + $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id] = $cart_item;
                        }else{
                            $cart_item = array();
                            $cart_item['id'] = $product['id'];
                            $cart_item['product_name'] = $product['product_name'];
                            $cart_item['product_image'] = $product['product_image'];
                            $cart_item['price'] = $product['price'];
                            $cart_item['quantity'] = $exist_quantity + $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id] = $cart_item;
                        }

                    }else{
                        $_SESSION['cart_item'] = array();
                        $cart_item = array();
                        $cart_item['id'] = $product['id'];
                        $cart_item['product_name'] = $product['product_name'];
                        $cart_item['product_image'] = $product['product_image'];
                        $cart_item['price'] = $product['price'];
                        $cart_item['quantity'] = $_POST['quantity'];
                        $_SESSION['cart_item'][$product_id] = $cart_item;
                    }
                }
                break;
            case 'remove':
                if(isset($_POST['product_id'])){
                    $product_id = $_POST['product_id'];
                    if(isset($_SESSION['cart_item'][$product_id])){
                        unset($_SESSION['cart_item'][$product_id]);
                    }
                }
                break;
            default:
                echo 'acction không tồn tại';
                die;
        }
    }
    echo '<br> $_POST';
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo '<br> $_SESSION';
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    header("Location: http://localhost:63342/simplecart/index.php");
    die();
}

die;