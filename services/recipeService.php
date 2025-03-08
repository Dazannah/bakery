<?php
require_once "./interfaces/IRecipeService.php";

class RecipeService implements IRecipeService {
  private mysqli $db;

  public function __construct(mysqli $db) {
    $this->db = $db;
  }

  public function getFreeColumn(): array {
    $lactoseFreeQuery = "SELECT name, price FROM Recipes WHERE lactoseFree = 1;";
    $glutenFreeQuery = "SELECT name, price FROM Recipes WHERE glutenFree = 1;";
    $lactoseAndGlutenFreeQuery = "SELECT name, price FROM Recipes WHERE glutenFree = 1 AND lactoseFree = 1;";

    $lactoseFreeResult = $this->db->query($lactoseFreeQuery);
    $glutenFreeResult = $this->db->query($glutenFreeQuery);
    $lactoseAndGlutenFreeResult = $this->db->query($lactoseAndGlutenFreeQuery);

    return ["lactoseFree" => $lactoseFreeResult->fetch_all(), "glutenFree" => $glutenFreeResult->fetch_all(), "glutenAndLactoseFree" => $lactoseAndGlutenFreeResult->fetch_all()];
  }
}
