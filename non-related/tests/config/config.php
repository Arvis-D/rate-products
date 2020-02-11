<?php

$mem = memory_get_usage();

class DBconf
{
    public const SHITE = 'mama';
    public const MAMAMA = 'mama';
    public const SAGsa = 'mama';
}

echo DBconf::SHITE;

$mem = memory_get_usage() - $mem;
echo "<br>" . $mem;