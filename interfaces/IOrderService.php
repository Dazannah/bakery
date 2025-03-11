<?php

interface IOrderService {
  public function calculateOrderPriceAndProfit(array $order): array;
}
