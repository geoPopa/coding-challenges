<?php

namespace MMarkets;

use MMarkets\Interface\Offer as OfferInterface;

class Offer implements OfferInterface
{
    public function __construct(
        public $offerId,
        public $productTitle,
        public $vendorId,
        public $price
    ) {
    }
}
