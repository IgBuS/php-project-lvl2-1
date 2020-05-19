<?php

namespace Differ\Formatters\Json;

function jsonFormatter($ast)
{
    return json_encode($ast);
}
