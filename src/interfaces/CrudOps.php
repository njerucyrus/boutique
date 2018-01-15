<?php
/**
 * Created by PhpStorm.
 * User: njerucyrus
 * Date: 1/12/18
 * Time: 4:34 PM
 */

namespace src\interfaces;


interface CrudOps
{
  public function create($data);
  public function update($id, $data);
  public function delete($id);
  public function getId($id);
  public function all();
}