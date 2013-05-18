<?php
/*
 * This file is part of the Mongator package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mongator\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Mondator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mondator';
    }

}