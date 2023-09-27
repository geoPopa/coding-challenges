<?php

namespace MMarkets;

use MMarkets\Interface\Reader as ReaderInterface;
use MMarkets\OfferCollection;

class JSONDataReader implements ReaderInterface
{
    /**
     * Read in incoming data and parse to objects
     */
    public function read(string $input): OfferCollection
    {
        $offers = json_decode($input, true);
        // var_dump($offers);
        return new OfferCollection($offers);
    }
}
