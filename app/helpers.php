<?php

declare(strict_types=1);

use Illuminate\Support\Str;

function slugify(string $text) : string
{
    return Str::of($text)->slug('-')->toString();
}

function getDefaultVersionSuffix() : string
{
    return '-v1';
}