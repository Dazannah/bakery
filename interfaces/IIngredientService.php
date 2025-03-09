<?php

interface IIngredientService {
  /** @return IngredientDTO[] */
  public function getIngredientsByRecipeId(int $recipeId): array;
}
