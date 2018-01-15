<?php
namespace src\controllers;

require_once __DIR__.'/../interfaces/CrudOps.php';
require_once __DIR__.'/../db/DB.php';


use src\db\DB;
use src\interfaces\CrudOps;

class ProductController implements CrudOps {
    
    public function create(array $data)
    {
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
    }

    public function update($id, array $data)
    {
        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("UPDATE  products SET store_id=:store_id, name=:name,
                          type=:type, description=:description
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
    }

    public function getId($id)
    {
        $sql = "SELECT  p.name, s.store_name as store_name,
                p.description,p.cost, p.quantity
                FROM products p  INNER  JOIN stores s ON s.id = p.store_id AND p.id='{$id}'";
        try{
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
    }

    public function delete($id)
    {
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
    }

    public function all()
    {
        $sql = "SELECT  p.name, s.store_name as store_name,
                p.description,p.cost, p.quantity
                FROM products p  INNER  JOIN stores s ON s.id = p.store_id WHERE 1";
        try{
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
    }

}