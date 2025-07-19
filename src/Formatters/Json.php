<?php

namespace Hexlet\Code\Formatters;

function renderJson(array $data): string|false
{
    return json_encode($data, JSON_PRETTY_PRINT);
}
