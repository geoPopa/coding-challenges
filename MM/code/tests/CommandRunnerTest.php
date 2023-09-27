<?php

use MMarkets\CommandReader;
use PHPUnit\Framework\TestCase;
use MMarkets\Offer;
use MMarkets\OfferCollection;

class ExposedCommandRunner extends CommandReader
{
    public function eDoesPropertyValueApply(
        Offer $offer,
        string $propertyName,
        string $filterType,
        array $values
    ): bool {
        return parent::doesPropertyValueApply(
            $offer,
            $propertyName,
            $filterType,
            $values
        );
    }
}

final class CommandRunnerTest extends TestCase
{
    protected ExposedCommandRunner $commandRunner;

    public function offersProvider()
    {
        return [
            [
                new Offer(1, "Title 1", 2, 12.3),
                "vendorId",
                CommandReader::FILTER_TYPE_EXACT,
                [2],
                true
            ]
        ];
    }

    /**
     * @dataProvider offersProvider
     */
    public function testFilterCheck(
        Offer $offer,
        string $propertyName,
        string $filterType,
        array $values,
        bool $result
    ) {
        $commandRunner = new ExposedCommandRunner(
            new OfferCollection([$offer]),
            "count_by_vendor_id",
            [1]
        );

        $this->assertEquals(
            $result,
            $commandRunner->eDoesPropertyValueApply(
                $offer,
                $propertyName,
                $filterType,
                $values
            )
        );
    }
}
