<?php
require_once "./interfaces/IModel.php";
require_once "./models/BaseModel.php";

class Recipe extends BaseModel implements IModel {
  public int|null $id;
  public string $name;
  public int $price;
  public int $lactoseFree;
  public int $glutenFree;

  public function __construct(string $name, int $price, bool $lactoseFree, bool $glutenFree, int|null $id = null) {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->lactoseFree = $lactoseFree;
    $this->glutenFree = $glutenFree;
  }

  public function getCreateSql(): string {
    return "INSERT INTO Recipes(name,price,lactoseFree,glutenFree) VALUES('$this->name','$this->price','$this->lactoseFree','$this->glutenFree')";
  }
}
