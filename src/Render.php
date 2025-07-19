<?php

namespace Hexlet\Code;

function render(array $data, string $format): string|false
{
    return getFormatter($data, $format);
}
