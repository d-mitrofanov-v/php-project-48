<?php

namespace Hexlet\Code\Formatters;

function renderJson($data): string
{
    return json_encode($data, JSON_PRETTY_PRINT);
}
