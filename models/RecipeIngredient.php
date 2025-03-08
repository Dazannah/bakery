 <?php

  class RecipeIngredient {
    public int $recipeId;
    public int $ingredientId;
    public int $amount;
    public int $unitId;

    public function __construct(int $recipeId, int $ingredientId, int $amount, int $unitId) {
      $this->recipeId = $recipeId;
      $this->ingredientId = $ingredientId;
      $this->amount = $amount;
      $this->unitId = $unitId;
    }

    public function getCreateSql() {
      return "INSERT INTO RecipesIngredients(recipeId,ingredientId,amount,unitId) VALUES('$this->recipeId', '$this->ingredientId', '$this->amount', '$this->unitId')";
    }
  }
