<?php

namespace MMarkets;

use Exception;
use MMarkets\OfferCollection;
use MMarkets\Offer;
use MMarkets\StringUtil;

class CommandReader
{
    const FILTER_TYPE_EXACT = "";
    const FILTER_TYPE_RANGE = "range";
    const FILTER_TYPES = [
        self::FILTER_TYPE_EXACT,
        self::FILTER_TYPE_RANGE
    ];

    const INVALID_ARGUMENT_COUNT_BY_MESSAGE = "Invalid count by argument %s";
    const INVALID_ARGUMENT_VALUES_MESSAGE = "Invalid values arguments %s";
    const INVALID_LOGGER_TYPE_MESSAGE = "Invalid logger type %s";

    const LOGGER_TYPE_NONE = 'none';
    const LOGGER_TYPE_CLI_OUTPUT = 'CLI_OUTPUT';
    const LOGGER_TYPE_FILE_OUTPUT = 'FILE_OUTPUT';

    const LOGGER_TYPES = [
        self::LOGGER_TYPE_NONE,
        self::LOGGER_TYPE_CLI_OUTPUT,
        self::LOGGER_TYPE_FILE_OUTPUT
    ];

    protected $availableProperties = [];
    protected $matchProperty;

    public function __construct(
        protected OfferCollection $offers,
        protected string $countBy = "",
        protected array $values = [],
        protected string $loggerType = self::LOGGER_TYPE_NONE
    ) {
        $this->matchProperty = $this->getMatchingProperty($this->countBy);

        if (empty($this->matchProperty)) {
            throw new Exception(printf(self::INVALID_ARGUMENT_COUNT_BY_MESSAGE, $this->countBy));
        }

        if (empty($this->values)) {
            throw new Exception(printf(self::INVALID_ARGUMENT_VALUES_MESSAGE, implode(", ", $this->values)));
        }

        if (!in_array($this->loggerType, self::LOGGER_TYPES)) {
            throw new Exception(printf(self::INVALID_LOGGER_TYPE_MESSAGE, $this->loggerType));
        }
    }

    public function run()
    {
        $offersIterator = $this->offers->getIterator();
        $count = 0;
        while ($offersIterator->valid()) {
            $offer = $this->offers->get($offersIterator->key());
            if (
                $this->doesPropertyValueApply(
                    $offer,
                    $this->matchProperty[0],
                    $this->matchProperty[1],
                    $this->values
                )
            ) $count++;
            $offersIterator->next();
        }

        return $count;
    }

    protected function getMatchingProperty(string $countBy): array
    {
        $this->log(__METHOD__, "countBy: $countBy");

        if (!empty($countBy)) {

            $snakeCaseCountBy = StringUtil::snakeCaseToCamelCase(
                $countBy
            );

            $filterTypesRegExp = "(" .
                implode(
                    "|",
                    array_map(
                        fn ($v) => ucfirst($v),
                        self::FILTER_TYPES
                    )
                ) . ")";

            foreach (self::getAvailableProperties() as $propertyName) {
                $regExp = "/^countBy(" . ucfirst($propertyName) . "){$filterTypesRegExp}$/i";
                $noMatches = preg_match($regExp, $snakeCaseCountBy, $matches);

                $this->log(
                    __METHOD__,
                    "Match result: "
                        . "\$noMatches = $noMatches"
                        . ", \$regExp = $regExp"
                        . ", \$snakeCaseCountBy = $snakeCaseCountBy"
                        . ", \$matches = [" . implode(", ", $matches) . "]"
                );

                if ($noMatches > 0) {
                    return [
                        $propertyName,
                        lcfirst($matches[2])
                    ];
                }
            }
        }

        return [];
    }

    protected function doesPropertyValueApply(
        Offer $offer,
        string $propertyName,
        string $filterType,
        array $values
    ): bool {
        $this->log(
            __METHOD__,
            "\$filterType = $filterType"
                . ", \$propertyName = $propertyName"
                . ", \$values = " . implode(", ", $values)
        );

        $testFunction = $this->getFilterFunctions()[$filterType];
        $value = $offer->{$propertyName};

        return call_user_func_array($testFunction, [$value, ...$values]);
    }

    protected function getFilterFunctions()
    {
        return [
            self::FILTER_TYPE_EXACT => function ($value, $compareTo) {
                $this->log(
                    __METHOD__,
                    "Compare $value to $compareTo with exact filter"
                );

                return "$value" === "$compareTo";
            },
            self::FILTER_TYPE_RANGE => function (float $value, float $from = 0, float $to = 0) {
                $this->log(
                    __METHOD__,
                    "Compare $value to range [$from $to]"
                );

                return max(min($value, $to), $from) == $value;
            }
        ];
    }

    protected function log($method, $message)
    {
        switch ($this->loggerType) {
            case self::LOGGER_TYPE_CLI_OUTPUT:
                echo "[$method] $message\n";
                break;
            case self::LOGGER_TYPE_FILE_OUTPUT:
                file_put_contents("run.php.out", "[$method] $message\n", FILE_APPEND);
            case self::LOGGER_TYPE_NONE:
                //nothing
            default;
        }
    }

    protected static function getAvailableProperties()
    {
        return array_keys(get_class_vars(Offer::class));
    }
}
