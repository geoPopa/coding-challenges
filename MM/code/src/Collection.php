<?php

namespace MMarkets;

use MMarkets\Interface\OfferCollection as OfferCollectionInterface;
use MMarkets\Offer;

class OfferCollection implements OfferCollectionInterface
{

    public function __construct(public array $offers = [])
    {
    }

    public function get(int $index): Offer
    {
        $iterator = $this->getIterator();
        while ($iterator->valid() && $iterator->key() < $index) $iterator->next();

        if ($iterator->valid()) {
            return $iterator->current();
        }
    }

    public function getIterator(): OffersIterator
    {
        return new OffersIterator(
            array_map(
                fn ($entryOffer) => new Offer(...$entryOffer),
                $this->offers
            )
        );
    }
}
