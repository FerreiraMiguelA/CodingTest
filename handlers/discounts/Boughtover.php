<?php

/**
 * This class contains all methods and atributes of boughtover releated discounts
 *
 * @author Artur Ferreira
 */
class Boughtover {
    private $config;
    private $customer;
    private $order;
    private $products;
    
    public function __construct($config, $customer, $order, $products) {
        $this->config = $config;
        $this->customer = $customer;
        $this->order = $order;
        $this->products = $products;
    }
    
    public function process() {
        $discount = false;
        $customer_total = $this->customer->getRevenue();
        $total_order = $this->order->getTotal();
        //echo $customer_total . ' > ' . $this->config['bought'] ;
        if ($customer_total > $this->config['bought']) {
            $discount['new_price'] = round($total_order * ((100-$this->config['discount']) / 100), 2);
            $discount['discount_value'] = $total_order - $discount['new_price'];
            $discount['description'] = "You already have bought over €" . $this->config['bought'] . " , so you get a discount of 10% on the whole order.";
        }
        
        return $discount;
    }

}
