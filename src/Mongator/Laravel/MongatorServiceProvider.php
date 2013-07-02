<?php
/*
 * This file is part of the Mongator package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mongator\Laravel;
use Illuminate\Support\ServiceProvider;

use Mongator\Mongator;
use Mongator\Connection;
use Mongator\Cache\ArrayCache;

use Mongator\Laravel\Command\IndexesCommand;
use Mongator\Laravel\Command\FixReferencesCommand;
use Mongator\Laravel\Command\GenerateCommand;

use Mandango\Mondator\Mondator;
use Mongator\Extension\Core;
use Log;

class MongatorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['config']->package('mongator/mongator', __DIR__ . '/../../../config');

        $this->registerMongator();
        $this->registerMetadata();
        $this->registerConnection();
        $this->registerCacheFields();
        $this->registerCacheData();
        $this->registerIndexCommand();
        $this->registerFixCommand();

        $this->registerMondator();
        $this->registerGenerateCommand();
    }

    protected function registerMongator()
    {
        $this->app['mongator'] = $this->app->share(function($app) {
            $mongator = new Mongator(
                $app['mongator.metadata'],
                $this->getLogger()
            );

            $mongator->setFieldsCache($app['mongator.cache.fields']);
            $mongator->setDataCache($app['mongator.cache.data']);
            $mongator->setConnection($app['config']['mongator::connection_name'], $app['mandango.connection']);
            $mongator->setDefaultConnectionName($app['config']['mongator::connection_name']);

            return $mongator;
        });
    }

    protected function registerMetadata()
    {
        $this->app['mongator.metadata'] = $this->app->share(function($app) {
            if ( !class_exists($app['config']['mongator::metadata_class']) ) {
                throw new \LogicException(
                    'You must register a valid "mongator::metadata_class" to this provider, maybe you forget to generate your models?'
                );
            }

            return new $app['config']['mongator::metadata_class']();
        });
    }

    protected function registerConnection()
    {
        $this->app['mandango.connection'] = $this->app->share(function($app) {
            if (!$app['config']['mongator::connection_dsn']) {
                throw new \LogicException(
                    'You must register "mongator::connection_dsn" to this provider'
                );
            }

            if (!$app['config']['mongator::connection_database']) {
                throw new \LogicException(
                    'You must register "mongator::connection_database" to this provider'
                );
            }

            return new Connection(
                $app['config']['mongator::connection_dsn'],
                $app['config']['mongator::connection_database']
            );
        });
    }

    protected function registerCacheFields()
    {
        $this->app['mongator.cache.fields'] = $this->app->share(function($app) {
            return new ArrayCache();
        });
    }

    protected function registerCacheData()
    {
        $this->app['mongator.cache.data'] = $this->app->share(function($app) {
            return new ArrayCache();
        });
    }

    protected function registerMondator()
    {
        $this->app['mondator'] = $this->app->share(function($app) {
            if (!$app['config']['mongator::models_output']) {
                throw new \LogicException(
                    'You must register "mongator::models_output" to this provider'
                );
            }

            if (!$app['config']['mongator::metadata_class']) {
                throw new \LogicException(
                    'You must register "mongator::metadata_class" to this provider'
                );
            }

            $extensions = array(
                new Core(array(
                    'metadata_factory_class' => $app['config']['mongator::metadata_class'],
                    'metadata_factory_output' => $app['config']['mongator::models_output'],
                    'default_output' => $app['config']['mongator::models_output'],
                ))
            );

            $mondator = new Mondator();
            $mondator->setExtensions(array_merge(
                $extensions,
                $app['config']['mongator::extensions']
            ));

            return $mondator;
        });
    }

    protected function getLogger()
    {
        if ( !$this->app['config']['mongator::logger'] ) return null;

        $querys = 0;

        return function($call) use (&$querys) {
            if ( !isset($call['collection']) ) $call['collection'] = 'none';
            $msg = sprintf(
                '[mongator] %s@%s.%s in %d sec(s), #%d',
                $call['type'], $call['database'],
                $call['collection'], $call['time'], ++$querys
            );

            Log::debug($msg);
        };
    }

    protected function registerGenerateCommand()
    {
        $this->app['command.generate'] = $this->app->share(function($app) {
            return new GenerateCommand();
        });

        $this->commands('command.generate');
    }

    protected function registerIndexCommand()
    {
        $this->app['command.index'] = $this->app->share(function($app) {
            return new IndexesCommand();
        });

        $this->commands('command.index');
    }

    protected function registerFixCommand()
    {
        $this->app['command.fix'] = $this->app->share(function($app) {
            return new FixReferencesCommand();
        });

        $this->commands('command.fix');
    }
    public function provides()
    {
        return array('mongator', 'mondator', 'command.generate');
    }
}
