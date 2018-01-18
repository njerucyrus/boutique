<?php

namespace src\controllers;

require_once __DIR__ . '/../interfaces/CrudOps.php';
require_once __DIR__ . '/../db/DB.php';
require_once __DIR__ . '/../controllers/TransactProduct.php';

use src\db\DB;
use src\interfaces\CrudOps;

class SalesController implements CrudOps
{
    use TransactProduct;

    public function create($data)
    {
        $errors = [];
        if (!is_array($data)) {
            array_push($errors, "parameter must be an array");
        }

        if (!array_key_exists("receipt_no", $data)) {
            array_push($errors, "receipt_no key missing in data passed");
        }

        if (!array_key_exists("product_id", $data)) {
            array_push($errors, "product_id key missing in data passed");
        }
        if (!array_key_exists("customer_id", $data)) {
            array_push($errors, "customer_id key missing in data passed");
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
                    ->prepare("INSERT INTO sales(receipt_no, product_id, customer_id, quantity, cost)
                          VALUES (:receipt_no, :product_id, :customer_id, :quantity, :cost)");
                $stmt->bindParam(":receipt_no", $data['receipt_no']);
                $stmt->bindParam(":product_id", $data['product_id']);
                $stmt->bindParam(":customer_id", $data['customer_id']);
                $stmt->bindParam(":quantity", $data['quantity']);
                $stmt->bindParam(":cost", $data['cost']);
                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Sale recorded Successfully "
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

        if (!array_key_exists("receipt_no", $data)) {
            array_push($errors, "receipt_no key missing in data passed");
        }

        if (!array_key_exists("product_id", $data)) {
            array_push($errors, "product_id key missing in data passed");
        }
        if (!array_key_exists("customer_id", $data)) {
            array_push($errors, "customer_id key missing in data passed");
        }
        if (!array_key_exists("quantity", $data)) {
            array_push($errors, "quantity key missing in data passed");
        }
        if (!array_key_exists("cost", $data)) {
            array_push($errors, "cost key missing in data passed");
        }
        if (!is_int($id)) {
            array_push($errors, "id not an integer");
        }


        if (sizeof($errors) == 0) {
            $db = new DB();
            try {
                $stmt = $db->connect()
                    ->prepare("UPDATE  sales SET receipt_no=:receipt_no, product_id=:product_id,
                          customer_id=:customer_id, quantity=:quantity, cost=:cost
                          WHERE id=:id");

                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":receipt_no", $data['receipt_no']);
                $stmt->bindParam(":product_id", $data['product_id']);
                $stmt->bindParam(":customer_id", $data['customer_id']);
                $stmt->bindParam(":quantity", $data['quantity']);
                $stmt->bindParam(":cost", $data['cost']);
                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Sale updated successfully"
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
            $sql = "SELECT DISTINCT s.receipt_no, p.name as product_name, p.cost,
       c.first_name, c.last_name, s.quantity, s.date_purchased
      FROM sales s, products p, customers c INNER JOIN sales sl
      ON c.id=sl.customer_id WHERE sl.id= '{$id}' ORDER BY sl.date_purchased ASC";
            $db = new DB();
            try {
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
                    ->prepare("DELETE FROM sales WHERE  id=:id");
                $stmt->bindParam(":id", $id);

                $query = $stmt->execute();
                if ($query) {
                    return [
                        "status" => "success",
                        "message" => "Sale Item deleted"
                    ];
                } else {
                    return [
                        "status" => "error",
                        "message" => "Error Occurred Failed to delete Sale Item"
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
        $sql = "SELECT DISTINCT s.receipt_no, p.name AS product_name, p.cost,
       c.first_name, c.last_name, s.quantity, s.date_purchased
      FROM sales s, products p, customers c INNER JOIN sales sl
      ON c.id=sl.customer_id ORDER BY sl.date_purchased ASC";
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