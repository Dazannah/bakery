<?php
class Recipe {
  public int $id;
  public string $name;
  public int $price;
  public int $lactoseFree;
  public int $glutenFree;
  /** @var array{ingredientId: int, unitId: int, ammount: int} */
  public array $ingredientIds;

  public function __construct(string $name, string $price, bool $lactoseFree, bool $glutenFree, int|null $id = null) {
    if ($id)
      $this->id = $id;
    $this->name = $name;
    $this->price = +explode(" ", $price)[0];
    $this->lactoseFree = $lactoseFree;
    $this->glutenFree = $glutenFree;
    //$ingredients;
  }

  public function getCreateSql() {
    return "INSERT INTO Recipes(name,price,lactoseFree,glutenFree) VALUES('$this->name','$this->price','$this->lactoseFree','$this->glutenFree')";
  }
}
