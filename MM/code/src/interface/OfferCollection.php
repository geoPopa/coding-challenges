<?php

namespace MMarkets\Interface;

use MMarkets\Interface\Offer as OfferInterface;
use Iterator;

/**
 * Interface for The Collection class that contains Offers
 */
interface OfferCollection
{
    public function get(int $index): OfferInterface;
    public function getIterator(): Iterator;
}
