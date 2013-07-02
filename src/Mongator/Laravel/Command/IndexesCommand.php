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

class IndexesCommand extends Command
{
    protected $name = 'mongator:indexes';
    protected $description = 'Ensure the indexes of all repositories';

    protected function fire()
    {
        $this->comment('Ensuring Indexes...');
        Mongator::ensureAllIndexes();

        $this->info('Done');
    }
}
