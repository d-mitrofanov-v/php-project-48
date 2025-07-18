<?php

namespace Hexlet\Code;

function render($data, $format): string
{
    return getFormatter($data, $format);
}
