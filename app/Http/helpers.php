<?php

use Carbon\CarbonInterval;

function getSeconds($time, $format = 'H:i:s')
{
    return CarbonInterval::createFromFormat($format, $time)->totalSeconds;
}
