<?php

/**
 * This class contains all methods and atributes of category releated discounts
 *
 * @author Artur Ferreira
 */
class Category {

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
    
    /**
     * Calls the category method discount
     * 
     * @return boolean|array
     */
    public function process() {
        $function = $this->config['method'];
        $discount = $this->$function();
        return $discount;
    }
    
    /**
     * Contains the logic of free products discount method
     * 
     * @access private
     * @return boolean|array
     */
    private function free() {

        foreach ($this->order->getItems() as $item) {
            if (!$this->categoryMarkedForDiscount($this->config['category'] 
                    ,$item->getProduct_id())) {
                continue;
            }
            
            if ($item->getQuantity() === $this->config['num_products']) {
                $item->setQuantity($item->getQuantity() + $this->config['num_products_free']);
                $discount['new_price'] = $this->order->getTotal();
                $discount['discount_value'] = $item->getUnit_price() * $this->config['num_products_free'];
                $discount['description'] = "Receive " . $this->config['num_products_free'] . " products free.";
                
                return $discount;
            }
        }
        return false;
    }
    
    /**
     * Contains the logic of cheapest products discount method
     * 
     * @access private
     * @return boolean|array
     */
    private function cheapest() {
        $num_products = 0;
        foreach ($this->order->getItems() as $item) {
            if (!$this->categoryMarkedForDiscount($this->config['category'] 
                    ,$item->getProduct_id())) {
                continue;
            }
            
            $num_products++;
        }
        
        if ($num_products < $this->config['num_products']) {
            return false;
        }
        
        $cheapest_item = $this->getCheapestItem();
        
        $disc = round($cheapest_item->getTotal() * ((100-$this->config['discount']) / 100), 2);
        $discount['discount_value'] = $cheapest_item->getTotal() - $disc;
        $discount['new_price'] = $this->order->getTotal() - $discount['discount_value'];
        $discount['description'] = "Receive discount of €" . $discount['discount_value'] . " on cheapest product.";
        
        return $discount;
    }
    
    /**
     * Gets the cheapest item
     * 
     * @return Item
     */
    private function getCheapestItem() {
        $product_price = 0;
        $cheapeast_item = "";
        foreach ($this->order->getItems() as $item) {
            if (!$this->categoryMarkedForDiscount($this->config['category'] 
                    ,$item->getProduct_id())) {
                continue;
            }
            
            if ($product_price === 0) {
                $product_price = $item->getUnit_price();
                $cheapeast_item = $item;
            } elseif ($item->getUnit_price() < $product_price) {
                $product_price = $item->getUnit_price();
                $cheapeast_item = $item;
            }
        }
        
        return $cheapeast_item;
    }
    
    /**
     * Checks if the category of product is marked for discount
     * 
     * @access private
     * @param array $categories
     * @param string $product_id
     * @return string
     */
    private function categoryMarkedForDiscount($categories, $product_id) {
        $category = $this->getProductCategory($product_id);
        return in_array($category, $categories);
    }
    
    /**
     * Returns product category
     * 
     * @access private
     * @param string $product_id
     * @return string
     */
    private function getProductCategory($product_id) {
        foreach ($this->products as $product) {
            if ($product->getId() === $product_id) {
                return $product->getCategory();
            }
        }
        die('Product not found');
    }

}
