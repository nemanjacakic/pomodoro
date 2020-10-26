<?php

use Carbon\CarbonInterval;

function getSeconds($time, $format = 'i:s')
{
    return CarbonInterval::createFromFormat($format, $time)->totalSeconds;
}
