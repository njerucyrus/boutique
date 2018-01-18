<?php


namespace src\controllers;
use src\db\DB;

trait TransactProduct
{
    public static function generateReceiptNo(){
        $receiptNo ='';

        for($i = 0; $i < 6; $i++) {
            $receiptNo .= mt_rand(0, 9);
        }

        return $receiptNo;
    }
//UPDATE THE quanty after a sale or lease
    public function updateQty($productId, $qty){
        try{
            $db = new DB();
            $stmt = $db->connect()
                ->prepare("UPDATE products SET quantity=quantity-{$qty} WHERE id={$productId}");
            if ($stmt->execute()){
                return true;
            }else{
                return false;
            }
        } catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function checkout($cartItems)
    {
        if (sizeof($cartItems) > 0) {
            foreach ($cartItems as $item):
                if ($this->create($item)["status"] == "success") {
                    $this->updateQty($item['product_id'], $item['quantity']);
                }
            endforeach;
        }
    }

}