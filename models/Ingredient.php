<?php
require_once "./interfaces/IModel.php";


class Ingredient implements IModel {
  public int|null $id;
  public string $name;
  public float $inventory;
  public int $unitId;

  public function __construct(string $name, float $inventory, int $unitId, int|null $id = null) {
    $this->id = $id;
    $this->name = $name;
    $this->inventory = $inventory;
    $this->unitId = $unitId;
  }

  public function getCreateSql(): string {
    return "INSERT INTO Ingredients(name, inventory, unitId) VALUES('$this->name','$this->inventory','$this->unitId')";
  }
}
