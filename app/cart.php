<?php
    namespace App;

    class Cart
    {
        // number of items
        public $items = null;
        // number of total quantity of all items
        public $totalQty = 0;
        // total price of all items
        public $totalPrice = 0;


        /*
        ** Constructor to add the old cart data to the new cart if the old cart is not null
        ** recieve parameters
        *** $oldCart to get old cart data
        ** no return
        */
        public function __construct($oldCart)
        {    
            if($oldCart)
            {
                $this->items = $oldCart->items;
                $this->totalQty = $oldCart->totalQty;
                $this->totalPrice = $oldCart->totalPrice;
            }

        }

        /*
        ** function to check if there is sale for this product or not
        ** recieve parameters
        *** $item to get item data (product price, sale price)
        *** $sale to get sale status
        */
        public function checkSale($item, $sale)
        {
            // if sale -> get sale price
            if($sale == 1)
            {
                $item_price = $item->sale_price;
            }
            // if not sale get the original price
            else
            {
                $item_price = $item->product_price;    
            }
            return $item_price;
        }

        /*
        ** function to add a new item
        ** recieve parameters
        *** $item to get the new item data
        *** $product_id to get the item id
        ** no return
        */
        public function add($item, $product_id)
        {
            // get the product price
            $getPrice = $this->checkSale($item, $item->sale);
            // default values of the item
            // qty -> quantity of one item
            $storedItem = ['qty' => 0, 'product_id' => 0, 'product_name' => $item->product_name,
            'product_price' => $getPrice, 'product_image' => $item->product_image, 'item' =>$item];

            // if I have an item, store it's data in variable -> $storedItem
            if($this->items){
                // check if the product id is exist in the items array, store this item in storedItems array
                if(array_key_exists($product_id, $this->items)){
                    $storedItem = $this->items[$product_id];
                }
            }

            // get a new item data
            $storedItem['qty']++;
            $storedItem['product_id'] = $product_id;
            $storedItem['product_name'] = $item->product_name;
            $storedItem['product_price'] = $getPrice;
            $storedItem['product_image'] = $item->product_image;
            $this->totalQty++;
            $this->totalPrice += $getPrice;
            $this->items[$product_id] = $storedItem;
        }

        /*
        ** function to update items quantity
        ** recieve parameters
        *** $id to detect the product
        *** $qty to get the quantity to update
        ** no return
        */
        public function updateQty($id, $qty)
        {
            // decrement the total quantity when decrease item quantity
            $this->totalQty -= $this->items[$id]['qty'];
            // decrement the total price when decrease item price
            $this->totalPrice -= $this->items[$id]['product_price'] * $this->items[$id]['qty'];
            // update the quantity
            $this->items[$id]['qty'] = $qty;
            // increment the total quantity when increase item quantity
            $this->totalQty += $qty;
            // increment the total price when increase item price
            $this->totalPrice += $this->items[$id]['product_price'] * $qty;
        }

        /*
        ** function to remove item
        ** recieve parameters
        *** $id to get the product
        ** no return
        */
        public function removeItem($id)
        {
            // decrement the total quantity when decrease item quantity
            $this->totalQty -= $this->items[$id]['qty'];
            // decrement the total price when decrease item price
            $this->totalPrice -= $this->items[$id]['product_price'] * $this->items[$id]['qty'];
            // remove the item
            unset($this->items[$id]);
        }

    }
?>
