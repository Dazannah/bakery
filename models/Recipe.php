<?php
class Recipe {
  public string $name;
  public int $price;
  public bool $lactoseFree;
  public bool $glutenFree;
  /** @var Ingredients[] */
  public array $ingredients;
}
