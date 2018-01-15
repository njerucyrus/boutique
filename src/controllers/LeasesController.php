<?php

namespace src\controllers;

require_once __DIR__ . '/../interfaces/CrudOps.php';
require_once __DIR__ . '/../db/DB.php';

use src\db\DB;
use src\interfaces\CrudOps;

class LeasesController implements CrudOps
{
    public function create(array $data)
    {
        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("INSERT INTO leases(receipt_no, product_id, customer_id, quantity)
                          VALUES (:receipt_no, :product_id, :customer_id, :quantity)");
            $stmt->bindParam(":receipt_no", $data['receipt_no']);
            $stmt->bindParam(":product_id", $data['product_id']);
            $stmt->bindParam(":customer_id", $data['customer_id']);
            $stmt->bindParam(":quantity", $data['quantity']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "Product Leased Successfully "
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to Record Sale"
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
                ->prepare("UPDATE  leases SET receipt_no=:receipt_no, product_id=:product_id,
                          customer_id=:customer_id, quantity=:quantity
                          WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":receipt_no", $data['receipt_no']);
            $stmt->bindParam(":product_id", $data['product_id']);
            $stmt->bindParam(":customer_id", $data['customer_id']);
            $stmt->bindParam(":quantity", $data['quantity']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "Leaded Product updated successfully"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to Store updated"
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
        $sql = "SELECT DISTINCT s.receipt_no, p.name as product_name, p.cost,
       c.first_name, c.last_name, s.quantity, s.date_leased
      FROM leases s, products p, customers c INNER JOIN leases sl
      ON c.id=sl.customer_id WHERE sl.id= '{$id}' LIMIT 1";
        $db = new DB();
        $stmt = $db->connect()
            ->prepare($sql);
        $query = $stmt->execute();
        if ($query) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } else {
            return [];
        }
    }

    public function delete($id)
    {

    }

    public function all()
    {
        $sql = "SELECT DISTINCT s.receipt_no, p.name AS product_name, p.cost,
       c.first_name, c.last_name, s.quantity, s.date_leased
      FROM leases s, products p, customers c INNER JOIN leases sl
      ON c.id=sl.customer_id ORDER BY sl.date_leased ASC";
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

}