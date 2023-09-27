<?php

namespace MMarkets\Interface;

use MMarkets\Interface\OfferCollection as OfferCollectionInterface;

/**
 * The interface provides the contract for different readers
 * E.g. it can be XML/JSON Remote Endpoint, or CSV/JSON/XML local files
 */
interface Reader
{
    /**
     * Read in incoming data and parse to objects
     */
    public function read(string $input): OfferCollectionInterface;
}
