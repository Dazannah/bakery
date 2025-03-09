<?php

interface IRecipeService {
  public function getFreeColumn(): array;
  /** @return RecipeDTO[] */
  public function getRecipesByIds(array $id): array;
}
