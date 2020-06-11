<?php

namespace Differ\Formatters\Json;

function formatToJson($ast)
{
    return json_encode($ast);
}
