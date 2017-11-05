<?php

use Models\Customer;
use Models\Product;
use Models\Order;
use Models\Item;

require_once 'model/Customer.php';
require_once 'model/Product.php';
require_once 'model/Order.php';
require_once 'model/Item.php';

$customers = getCustomerData();
$products = getProdutsData();
$orders = getOrdersData();
$discount_rules = jsonDecode(getFileData('data/discounts_rules.json'));

foreach ($orders as $order) {
    $result_discount = false;
    $customer = getCustomer($order->getCustomer_id(), $customers);

    foreach ($discount_rules as $rule) {
        $handler = dirname(__FILE__) . '/handlers/discounts/' . ucfirst($rule['type']) . '.php';
        $class = ucfirst($rule['type']);

        if (!file_exists($handler)) {
            die('File not found');
        }

        require_once $handler;

        $handlerObj = new $class($rule, $customer, $order, $products);
        $result_discount = $handlerObj->process();

        if (is_array($result_discount)) {
            break;
        }
    }
    echo '<strong>Customer:</strong> ' . $customer->getName() . '<br>';
    echo '<strong>Order:</strong> ' . $order->getId() . '<br>';

    if ($result_discount === false) {
        echo '<strong>Discount:</strong> No discount' . '<br><br>';
    } else {
        echo '<strong>Discount:</strong> <pre>' . print_r($result_discount, true) . '</pre>' . '<br><br>';
    }
}

/**
 * Gets customers data
 * 
 * @return Customer
 */
function getCustomerData() {
    $customers_decoded = jsonDecode(getFileData('data/customers.json'));

    foreach ($customers_decoded as $customer) {
        $customers[] = new Customer($customer['id'], $customer['name'], $customer['since'], $customer['revenue']);
    }

    return $customers;
}

/**
 * Gets products data
 * 
 * @return Product
 */
function getProdutsData() {
    $products_decoded = jsonDecode(getFileData('data/products.json'));

    foreach ($products_decoded as $product) {
        $products[] = new Product($product['id'], $product['description'], $product['category'], $product['price']);
    }

    return $products;
}

/**
 * Gets orders data
 * 
 * @return Order
 */
function getOrdersData() {
    $orders_decoded = jsonDecode(getFileData('data/orders.json'));

    foreach ($orders_decoded as $order) {
        $order_items = array();

        foreach ($order['items'] as $item) {
            $order_items[] = new Item($item['product-id'], $item['quantity'], $item['unit-price'], $item['total']);
        }

        $orders[] = new Order($order['id'], $order['customer-id'], $order_items, $order['total']);
    }

    return $orders;
}

/**
 * Gets customer by id
 * 
 * @param string $customer_id
 * @param array $array_customers
 * @return Customer
 */
function getCustomer($customer_id, $array_customers) {
    foreach ($array_customers as $customer) {
        if ($customer_id === $customer->getId()) {
            return $customer;
        }
    }
    die('Customer not found');
}

/**
 * Gets content of file
 * 
 * @param string $path
 * @return string
 */
function getFileData($path) {
    $data = file_get_contents($path);

    return $data;
}

/**
 * Gets json decoded
 * 
 * @param string $str
 * @return array
 */
function jsonDecode($str) {
    $json_decoded = json_decode($str, true);

    return $json_decoded;
}
