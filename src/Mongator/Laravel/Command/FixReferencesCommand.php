<?php
/*
 * This file is part of the Mongator package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mongator\Laravel\Command;
use Illuminate\Console\Command;
use Mongator;

class FixReferencesCommand extends Command
{
    protected $name = 'mongator:fix';
    protected $description = 'Fixes all the missing references';

    protected function fire()
    {
        $this->comment('Fixing missing References...');        
        Mongator::fixAllMissingReferences();

        $this->info('Done');
    }
}