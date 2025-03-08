<?php
require_once "./interfaces/IModel.php";


class Unit implements IModel {
  public int|null $id;
  public string $name;

  public function __construct(string $name, int|null $id = null) {
    $this->id = $id;
    $this->name = $name;
  }

  public function getCreateSql(): string {
    return "INSERT INTO Units(name) VALUES('$this->name')";
  }
}
