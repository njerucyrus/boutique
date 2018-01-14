<?php

namespace src\controllers;

use src\interfaces\CrudOps;
use src\db\DB;

class UserController implements CrudOps
{

    public function create(array $data)
    {
        $db = new DB();
        try {
            $stmt = $db->connect()
                ->prepare("INSERT INTO users(username, password, user_type)
                          VALUES (:username, :password, user_type)");
            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":password", bcrypt($data['password'], PASSWORD_BCRYPT));
            $stmt->bindParam(":user_type", $data['user_type']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "User Account created successfully"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to create user account"
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
                ->prepare("UPDATE  users SET username=:username, password=:password, user_type=:user_type
                          WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":password", bcrypt($data['password'], PASSWORD_BCRYPT));
            $stmt->bindParam(":user_type", $data['user_type']);
            $query = $stmt->execute();
            if ($query) {
                return [
                    "status" => "success",
                    "message" => "User Account updated successfully"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Error Occurred Failed to update user account"
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
                ->prepare("SELECT t.* FROM users t WHERE  t.id=:id");
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
                ->prepare("SELECT t.* FROM users t WHERE  t.id=:id");
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