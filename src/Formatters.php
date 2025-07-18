<?php

namespace Hexlet\Code;

use function Hexlet\Code\Formatters\renderPlain;
use function Hexlet\Code\Formatters\renderStylish;

function getFormatter($data, $format): string
{
    $renderer = match ($format) {
        'stylish' => fn() => renderStylish($data),
        'plain' => fn() => renderPlain($data),
    };

    return $renderer($data);
}
