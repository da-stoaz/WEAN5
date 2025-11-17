<?php

namespace App\Enums;

enum HeatpumpType: string
{
    case AIR_WATER = 'Air-to-Water';
    case BRINE_WATER = 'Brine-to-Water';
    case WATER_WATER = 'Water-to-Water';
    case AIR_AIR = 'Air-to-Air';
}