<?php

class Ingredient {
  public int $id;
  public string $name;

  public function __construct($name, $id = null) {
    $this->name = $name;

    if ($id)
      $this->id = $id;
  }

  public function getCreateSql() {
    return "INSERT INTO Ingredients(name) VALUES('$this->name')";
  }
}
