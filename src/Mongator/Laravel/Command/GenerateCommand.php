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
use Config, Mondator;

class GenerateCommand extends Command
{
    protected $name = 'mongator:generate';
    protected $description = 'Process config classes and generate the files of the classes';

    protected function fire()
    {

        $this->comment('Generating models...', false);        
        
        $path = Config::get('mongator::models_input');
        if ( !is_dir($path) ) {
            throw new \LogicException(
                'Registered "mongator::models_input" not is a valid path.'
            );
        }
        
        Mondator::setConfigClasses($this->readYAMLs($path));
        Mondator::process();

        $this->info('Done');
    }


    private function readYAMLs($paths)
    {
        if ( !is_array($paths) ) $paths = (array)$paths;

        $defs = array();
        foreach($paths as $path) {
            foreach ($this->findYAMLs($path . '/*.yaml') as $file) {
                $defs = array_merge($defs, yaml_parse(file_get_contents($file)));
            }
        }

        return $defs;
    }

    private function findYAMLs($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR) as $dir) {
            $files = array_merge($files, $this->findYAMLs($dir.'/'.basename($pattern), $flags));
        }
        
        return $files;
    }
}