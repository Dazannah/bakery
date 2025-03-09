<?php
class RecipeDTO {
  public int $id;
  public string $name;
  public int $price;
  public int $lactoseFree;
  public int $glutenFree;
  /** @var IngredientDTO[] */
  public array $ingredients;

  public function __construct(string $name, int $price, bool $lactoseFree, bool $glutenFree, int $id, array $ingredients) {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->lactoseFree = $lactoseFree;
    $this->glutenFree = $glutenFree;
    $this->ingredients = $ingredients;
  }
}
