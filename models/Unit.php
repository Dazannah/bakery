<?php

class Unit {
  public int $id;
  public string $name;

  public function __construct($name, $id = null) {
    $this->name = $name;

    if ($id)
      $this->id = $id;
  }

  public function getCreateSql() {
    return "INSERT INTO Units(name) VALUES('$this->name')";
  }
}
