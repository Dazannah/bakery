<?php
interface IProfitService {
  public function getLastWeekProfit(): int|float;
  public function calculateProfit(array $recipes, array $sales, int $income): int;
}
