<?php

function Leap(int $year) : bool
{
    return (($year % 4) == 0) ? true : false;
}

echo Leap(2012);