<?php
namespace src\controllers;

require_once __DIR__.'/../interfaces/CrudOps.php';
require_once __DIR__.'/../db/DB.php';

use src\interfaces\CrudOps;
use src\db\DB;

class StoreController implements CrudOps{
    public function create(array $data)
    {
        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("INSERT INTO stores(store_name, address)
                          VALUES (:store_name, :address)");
            $stmt->bindParam(":store_name", $data['store_name']);
            $stmt->bindParam(":address", $data['address']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "Store added successfully"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to add Store"
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
                ->prepare("UPDATE  stores SET store_name=:store_name, address=:address
                          WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":store_name", $data['store_name']);
            $stmt->bindParam(":address", $data['address']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "Store updated successfully"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed , Store not  updated"
                ];
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
                ->prepare("DELETE FROM stores WHERE  id=:id");
            $stmt->bindParam(":id", $id);

            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "Store deleted"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to delete store"
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
        try {

            $db = new DB();
            $stmt = $db->connect()
                ->prepare("SELECT t.* FROM stores t WHERE  t.id=:id");
            $stmt->bindParam(":id", $id);
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

    public function all()
    {
        try {

            $db = new DB();
            $stmt = $db->connect()
                ->prepare("SELECT t.* FROM stores t WHERE  t.id=:id");
            $stmt->bindParam(":id", $id);
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