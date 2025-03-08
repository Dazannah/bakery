<?php
require_once "./interfaces/IModel.php";


class Ingredient implements IModel {
  public int|null $id;
  public string $name;

  public function __construct(string $name, int|null $id = null) {
    $this->id = $id;
    $this->name = $name;
  }

  public function getCreateSql(): string {
    return "INSERT INTO Ingredients(name) VALUES('$this->name')";
  }
}
