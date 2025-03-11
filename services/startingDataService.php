<?php
require_once "./singletons/db.php";
require_once "./models/Ingredient.php";
require_once "./models/Unit.php";
require_once "./models/Recipe.php";
require_once "./models/RecipeIngredient.php";
require_once "./models/Sale.php";
require_once "./models/WholesalePrice.php";

class StartingDataService {
  private static $duplicateRegexp = "/duplicate/i";
  private static $data;
  private static $units = [];
  private static $ingredients = [];
  private static $recipes = [];

  public static function addProvidedData(string $dataLocation) {
    self::saveUnits();

    $dataFile = fopen($dataLocation, "r") or die("Unable to open config file!");
    self::$data = json_decode(fread($dataFile, filesize($dataLocation)));

    self::saveIngredients();
    self::saveRecipes();
    self::saveSalesOfLastWeek();
    self::saveWholeSalePrices();
  }

  private static function saveUnits() {
    $unitsLocation = "units.json";
    $unitsFile = fopen($unitsLocation, "r") or die("Unable to open units file!");
    $unitsJson = json_decode(fread($unitsFile, filesize($unitsLocation)));

    foreach ($unitsJson as $unit) {
      try {
        $unit = new Unit($unit);
        $unit->create();

        self::$units[$unit->name] = $unit;
      } catch (Exception $ex) {
        if (!preg_match(self::$duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }

  private static function saveIngredients() {
    foreach (self::$data->inventory as $inventory) {
      $explodedAmount = explode(" ", $inventory->amount);

      if (!isset(self::$units[$explodedAmount[1]]))
        continue;

      if ($explodedAmount[1] == "kg" || $explodedAmount[1] == "l") {
        $explodedAmount[0] *= 1000;
        $explodedAmount[1] = $explodedAmount[1] == "kg" ? "g" : "ml";
      }

      try {
        $ingredient = new Ingredient($inventory->name, $explodedAmount[0], self::$units[$explodedAmount[1]]->id);
        $ingredient->create();

        self::$ingredients[$ingredient->name] = $ingredient;
      } catch (Exception $ex) {
        if (!preg_match(self::$duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }

  private static function saveRecipes() {
    foreach (self::$data->recipes as $recipe) {
      try {
        $newRecipe = new Recipe($recipe->name, explode(" ", $recipe->price)[0], $recipe->lactoseFree, $recipe->glutenFree);
        $newRecipe->create();

        self::$recipes[$newRecipe->name] = $newRecipe;

        self::saveRecipeIngredients($recipe, $newRecipe->id);
      } catch (Exception $ex) {
        if (!preg_match(self::$duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }

  private static function saveRecipeIngredients($recipe, $recipeId) {
    foreach ($recipe->ingredients as $ingredient) {
      $explodedUnit = explode(" ", $ingredient->amount);

      try {
        $newRecipeIngredient = new RecipeIngredient($recipeId, self::$ingredients[$ingredient->name]->id, $explodedUnit[0], self::$units[$explodedUnit[1]]->id);
        $newRecipeIngredient->create();
      } catch (Exception $ex) {
        if (!preg_match(self::$duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }

  private static function saveSalesOfLastWeek() {
    foreach (self::$data->salesOfLastWeek as $sale) {
      if (!isset(self::$recipes[$sale->name]))
        continue;

      try {
        $recipeId = self::$recipes[$sale->name]->id;
        $newSale = new Sale($recipeId, $sale->amount);
        $newSale->create();
      } catch (Exception $ex) {
        if (!preg_match(self::$duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }

  private static function saveWholeSalePrices() {
    foreach (self::$data->wholesalePrices as $wholesalePrice) {
      $explodedUnit = explode(" ", $wholesalePrice->amount);
      if (!isset(self::$ingredients[$wholesalePrice->name]) || !isset(self::$units[$explodedUnit[1]]))
        continue;

      try {
        $newWholesalePrice = new WholesalePrice(self::$ingredients[$wholesalePrice->name]->id, $explodedUnit[0], self::$units[$explodedUnit[1]]->id, $wholesalePrice->price);
        $newWholesalePrice->create();
      } catch (Exception $ex) {
        if (!preg_match(self::$duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }
}
