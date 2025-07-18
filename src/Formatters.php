<?php

namespace Hexlet\Code;

use function Hexlet\Code\Formatters\renderPlain;
use function Hexlet\Code\Formatters\renderStylish;
use function Hexlet\Code\Formatters\renderJson;

function getFormatter($data, $format): string
{
    $renderer = match ($format) {
        'stylish' => fn() => renderStylish($data),
        'plain' => fn() => renderPlain($data),
        'json' => fn() => renderJson($data)
    };

    return $renderer($data);
}
