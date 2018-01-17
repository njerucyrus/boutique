<?php
namespace src\controllers;

require_once __DIR__.'/../interfaces/CrudOps.php';
require_once __DIR__.'/../db/DB.php';


use src\db\DB;
use src\interfaces\CrudOps;

class ProductController implements CrudOps {
    
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
        } else{
            return [
                "status"=>"error",
                "message"=>"Data validation failed. Access errors key for specific errors",
                "errors" =>$errors
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
        if(!is_int($id)){
            array_push($errors, "id not an Integer");
        }
        if(sizeof($errors) == 0) {
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
        }else{
            return [
                "status"=>"error",
                "message"=>"Data validation failed. Access errors key for specific errors",
                "errors" =>$errors
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
        }else{
            return [
                "status" => "error",
                "message" => "Data validation failed. Access errors key for specific errors",
                "errors" => ["Expects an integer"]
            ];
        }
    }

    public function delete($id)
    {
        if (is_int($id)){
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
        }else{
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
        try{
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

}