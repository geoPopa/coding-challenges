<?php

require_once './vendor/autoload.php';

use MMarkets\JSONDataReader;
use MMarkets\CommandReader;

$dataEndPoint = 'http://web-server/data/offers.json';

$sData = file_get_contents($dataEndPoint);
$offers = (new JSONDataReader())->read($sData);
// var_dump($offers->get(1));

array_shift($argv);
$countBy = array_shift($argv) ?? "";
$command = new CommandReader(
    $offers,
    $countBy,
    $argv,
    CommandReader::LOGGER_TYPE_FILE_OUTPUT
);
echo $command->run() . "\n";
