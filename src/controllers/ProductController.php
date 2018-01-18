<?php

namespace src\controllers;

require_once __DIR__ . '/../interfaces/CrudOps.php';
require_once __DIR__ . '/../db/DB.php';


use src\db\DB;
use src\interfaces\CrudOps;

class ProductController implements CrudOps
{

    public function create($data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("store_id", $data)) {
            array_push($errors, "store_id key missing in data passed");
        }

        if (!array_key_exists("name", $data)) {
            array_push($errors, "name key missing in data passed");
        }
        if (!array_key_exists("type", $data)) {
            array_push($errors, "type key missing in data passed");
        }
        if (!array_key_exists("quantity", $data)) {
            array_push($errors, "quantity key missing in data passed");
        }
        if (!array_key_exists("cost", $data)) {
            array_push($errors, "cost key missing in data passed");
        }

        if (sizeof($errors) == 0) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("INSERT INTO products(store_id, name, type, description, cost, quantity)
                          VALUES (:store_id, :name, :type, :description, :cost, :quantity)");
                $stmt->bindParam(":store_id", $data['store_id']);
                $stmt->bindParam(":name", $data['name']);
                $stmt->bindParam(":type", $data['type']);
                $stmt->bindParam(":description", $data['description']);
                $stmt->bindParam(":cost", $data['cost']);
                $stmt->bindParam(":quantity", $data['quantity']);
                $query = $stmt->execute();

                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Product added successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to add Product {$stmt->errorInfo()[2]}"
                    ];
                }

            } catch (\PDOException $e) {
                $e->getMessage();
                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => $errors
            ];
        }
    }

    public function update($id, $data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("store_id", $data)) {
            array_push($errors, "store_id key missing in data passed");
        }

        if (!array_key_exists("name", $data)) {
            array_push($errors, "name key missing in data passed");
        }
        if (!array_key_exists("type", $data)) {
            array_push($errors, "type key missing in data passed");
        }
        if (!array_key_exists("quantity", $data)) {
            array_push($errors, "quantity key missing in data passed");
        }
        if (!array_key_exists("cost", $data)) {
            array_push($errors, "cost key missing in data passed");
        }
        if (!is_int($id)) {
            array_push($errors, "id not an Integer");
        }
        if (sizeof($errors) == 0) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("UPDATE  products SET store_id=:store_id, name=:name,
                          type=:type, description=:description, cost=:cost,quantity=:quantity
                          WHERE id=:id");

                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":store_id", $data['store_id']);
                $stmt->bindParam(":name", $data['name']);
                $stmt->bindParam(":type", $data['type']);
                $stmt->bindParam(":description", $data['description']);
                $stmt->bindParam(":cost", $data['cost']);
                $stmt->bindParam(":quantity", $data['quantity']);
                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Product updated successfully"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to Product not updated"
                    ];
                }

            } catch (\PDOException $e) {

                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => $errors
            ];
        }
    }

    public function getId($id)
    {
        if (is_int($id)) {
            $sql = "SELECT  p.name, s.store_name as store_name,
                p.description,p.cost, p.quantity
                FROM products p  INNER  JOIN stores s ON s.id = p.store_id AND p.id='{$id}'";
            try {
                $db = new DB();
                $stmt = $db->connect()
                    ->prepare($sql);
                $query = $stmt->execute();
                if ($query) {
                    return $stmt->fetch(\PDO::FETCH_ASSOC);

                } else {
                    return [];
                }
            } catch (\PDOException $e) {

                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => ["Expects an integer"]
            ];
        }
    }

    public function delete($id)
    {
        if (is_int($id)) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("DELETE FROM products WHERE  id=:id");
                $stmt->bindParam(":id", $id);

                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Product Item deleted"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to delete Product Item"
                    ];
                }


            } catch (\PDOException $e) {
                return [
                    "status" => "error",
                    "message" => "Exception Error {$e->getMessage()}"
                ];

            }
        } else {
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => ["Expects an integer"]
            ];
        }
    }

    public function all()
    {


        $sql = "SELECT p.id, p.name, s.store_name as store_name,p.type,
                p.description,p.cost, p.quantity
                FROM products p  INNER  JOIN stores s ON s.id = p.store_id WHERE 1";
        try {
            $db = new DB();
            $stmt = $db->connect()
                ->prepare($sql);
            $query = $stmt->execute();
            if ($query) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);

            } else {
                return [];
            }
        } catch (\PDOException $e) {

            return [
                "status" => "error",
                "message" => "Exception Error {$e->getMessage()}"
            ];
        }
    }

    public static function moveProduct($data)
    {
        $productId = $data['product']['id'];
        $currentQty = $data['product']['quantity'];
        $from_store_id = $data['product']['from_store_id'];
        $productName = $data['product']['name'];
        $description = $data['product']['description'];
        $cost = $data['product']['cost'];
        $type = $data['product']['type'];

        $qtyToMove = $data['qty_to_move'];
        $to_store_id = $data['to_store_id'];

        $storeCtrl = new StoreController();
        $store = $storeCtrl->getId((int)$from_store_id);
        $difference = $qtyToMove - $currentQty;
        $response = null;
        if ($difference < 0) {
            return [
                "status"=>"error",
                "message"=>"Quantity is insufficient.Cannot move more products that what is in the store"
            ];
        } else {
            $productExists = self::checkProductExistsInStore($data['product']['name'], $to_store_id);

            try {
                //if product exists just update the quantity
                //else insert
                $sql = "";


                if ($productExists) {
                    $sql = "UPDATE products set quantity=quantity+'{$qtyToMove}' WHERE store_id='{$to_store_id}' AND 
                      id='{$productId}'";
                }
                if (!$productExists) {
                    $data = [
                        "store_id"=>(int)$to_store_id,
                        "name"=>$productName,
                        "type"=>$type,
                        "description"=>$description,
                        "cost"=>$cost,
                        "quantity"=>$qtyToMove
                    ];

                    $created= (new self)->create($data);
                    if ($created['status'] == 'success'){
                        $response = [
                            "status" => "success",
                            "message" => "{$qtyToMove} {$productName} Moved to store {$store['name']} "
                        ];

                        if ($difference == 0){
                            //delete the product form the store
                            self::clearProduct($productId, $from_store_id);
                        }
                    }

                }
                $db = new DB();
                $stmt = $db->connect()->prepare($sql);
                $query = $stmt->execute();
                if ($query) {
                    self::updateStoreQty($productId, $from_store_id, $qtyToMove);
                    $response = [
                        "status" => "success",
                        "message" => "{$qtyToMove} {$productName} Moved to store {$store['name']} "
                    ];

                    if ($difference == 0){
                        //delete the product form the store
                        self::clearProduct($productId, $from_store_id);
                    }

                } else {
                    $response = [
                        "status" => "error",
                        "message" => "SQL error Occurred: {$stmt->errorInfo()[2]}"
                    ];
                }

                return $response;

            } catch (\PDOException $e) {

                return [
                    "status" => "error",
                    "message" => "Error {$e->getMessage()}"
                ];
            }
        }

    }

    public static function checkProductExistsInStore($productName, $storeId)
    {

        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("SELECT * FROM products WHERE products.name='{$productName}'
                          AND products.store_id={$storeId} LIMIT 1");

            if ($stmt->execute() and $stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function updateStoreQty($productId, $storeId, $qty)
    {
        try {
            $db = new DB();
            $stmt = $db->connect()
                ->prepare("UPDATE products SET quantity=quantity-'{$qty}' WHERE products.store_id='{$storeId}'
                          AND products.id='{$productId}'");
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function clearProduct($productId, $storeId){
        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("DELETE FROM products WHERE  id=:id and store_id=:store_id");
            $stmt->bindParam(":id", $productId);
            $stmt->bindParam(":id", $storeId);

            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "Product Item deleted"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to delete Product Item"
                ];
            }


        } catch (\PDOException $e) {
            return [
                "status" => "error",
                "message" => "Exception Error {$e->getMessage()}"
            ];

        }
    }
}