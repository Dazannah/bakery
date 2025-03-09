<?php

interface IWholesalePriceService {
  public function getSelectAllQuery(): string;
  /** @return WholesalePriceDTO[] */
  public function getAll(): array;
  /** @return array<int|float> */
  public function getBasePrices(): array;
}
