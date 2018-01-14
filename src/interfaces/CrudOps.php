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
  public function create(array $data);
  public function update($id, array $data);
  public function getId($id);
  public function all();
}