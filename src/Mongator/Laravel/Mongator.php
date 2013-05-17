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
use Config;

use Mongator\Mongator as Base;
use Mongator\Connection;
use Mongator\Cache\ArrayCache;

class Mongator {
    public static $instance;

    private $mongator;
    private $metadata;
    private $logger;
    private $fieldsCache;
    private $dataCache;
    private $connection;
    private $config;

    public static function instance()
    {
        if ( !self::$instance) self::$instance = new self();
        return self::$instance;
    }

    public function __construct()
    {
        $this->loader = require __DIR__.'/../vendor/autoload.php';
        $this->loader->add(
            Config::get('mongator::config.models.namespace'), 
            Config::get('mongator::config.models.output')
        );
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array(
            array($this->getMongator(), $method),
            $arguments
        );
    }

    private function getMongator()
    {
        if ( $this->mongator ) return $this->mongator;

        $this->mongator = new Base($this->getMetadata(), $this->getLogger());

        $this->mongator->setFieldsCache($this->getFieldsCache());
        $this->mongator->setDataCache($this->getDataCache());
        $this->mongator->setConnection(
            Config::get('mongator::config.connection.name'),
            $this->getConnection()
        );

        $this->mongator->setDefaultConnectionName(Config::get('mongator::config.connection.name'));

        return $this->mongator;
    }

    private function getMetadata()
    {
        if ( $this->metadata ) return $this->metadata;

        if ( !class_exists($class = Config::get('mongator::config.metadata')) ) {
            throw new \LogicException(
                'You must configure a valid "mongator_metadata_class" to this spark, maybe you forget to generate your models?'
            );
        }

        $this->metadata = new $class();
        return $this->metadata;
    }

    private function getFieldsCache()
    {
        if ( $this->fieldsCache ) return $this->fieldsCache;

        $this->fieldsCache = new Mongator\Cache\ArrayCache();
        return $this->fieldsCache;
    }

    private function getDataCache()
    {
        if ( $this->dataCache ) return $this->dataCache;

        $this->dataCache = new Mongator\Cache\ArrayCache();
        return $this->dataCache;
    }

    private function getConnection()
    {
        if ( $this->connection ) return $this->connection;

        if (!$dsn = Config::get('mongator::config.connection.dsn')) {
            throw new \LogicException(
                'You must configure "mongator_connection_dsn" to this spark'
            );
        }
    
        if (!$database = Config::get('mongator::config.connection.database')) {
            throw new \LogicException(
                'You must configure "mongator_connection_database" to this spark'
            );
        }

        $this->connection = new Mongator\Connection($dsn, $database);
        return $this->connection;
    }

    private function getLogger()
    {
        if ( ENVIRONMENT != 'development' ) return null;

        if ( $this->logger ) return $this->logger;

        $querys = 0;
        $this->logger = function($call) use (&$querys) {
            if ( !isset($call['collection']) ) $call['collection'] = 'none';

            $msg = sprintf(
                '[mongator] %s@%s.%s in %d sec(s), #%d',  
                $call['type'], $call['database'], 
                $call['collection'], $call['time'], ++$querys
            );

            log_message('debug', $msg);
        };

        return $this->logger;
    }
}