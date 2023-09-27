<?php

namespace MMarkets;

class StringUtil
{
    public static function snakeCaseToCamelCase($snakeCaseInput)
    {
        return lcfirst(
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace('_', ' ', $snakeCaseInput)
                )
            )
        );
    }
}
