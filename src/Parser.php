<?php

namespace Hexlet\Code;

function getFileContent($jsonPath)
{
    $jsonContent = file_get_contents($jsonPath);
    return json_decode($jsonContent);
}
