<?php

namespace PluginSystem;

use \Library\Framework\Plugin\Migration;

abstract class AbstractPlugin implements PluginActivationIF, PluginDeactivationIF, PluginInstallIF
{
    protected $name = null;
    protected $basePath = null;
    
    public function __construct( $name )
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $name;
    }
    
    /**
     * Get an array of available migrations for this plugin
     * 
     * @return multitype:string
     */
    public function getMigrations()
    {
        $migrate = new \Migration\Migrate();
        $migrationsRun = $migrate->getMigrationsRun();
        
        $system = \Plugin\PluginSystem::getInstance();
        $location = $system->getPluginPath( $this->name );
        $migrations = array();
        if ( file_exists( "$location/migrations" ) ) {
            foreach ( glob( "$location/migrations/*.php" ) as $migrationFile ) {
                $filename = basename( $migrationFile );
                if ( !isset( $migrationsRun[$filename] ) ) {
                    include_once "$location/migrations/$filename";
                    $migrations[]= $filename;
                }
            }
        }
        
        return $migrations;
    }
    
    public function migrate()
    {
        $migrate = new \Migration\Migrate();
        
        $lastBatchNumber = $migrate->getLastBatchNumber();
        $nextBatchNumber = $lastBatchNumber + 1;
        
        // All of the migration files have been collected and sorted
        // Iterate over them and execute the directives
        $migrated = array();
        foreach ( $this->getMigrations() as $migration ) {
            $class = str_replace( ".php", "", $migration );
            $mObj = new $class();
            if ( $mObj instanceof \Migration\Migration ) {
                $directive = $mObj->up();
                $migrate->upgradeFromDirective( $directive );
                $migrate->insertMigration( $migration, $nextBatchNumber );
                $migrated[]= $migration;
            }
        }
    }

    public function update()
    {
        $this->migrate();
    }
    
    public function install()
    {
        $this->migrate();
    }
    
    public function activate()
    {
              
    }
    
    public function deactivate()
    {

    }
}
