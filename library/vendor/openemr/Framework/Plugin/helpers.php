<?php
/**
* Plugin API
*
*
*/

function add_action( $key, $callback )
{
$system = \Framework\Plugin\PluginSystem::getInstance();
$system->addAction( $key, $callback );
}

function do_action( $key, & $args = null )
{
$system = \Framework\Plugin\PluginSystem::getInstance();
$system->doAction( $key, $args );
}

function register_plugin( \Framework\Plugin\AbstractPlugin $plugin )
{
$system = \Framework\Plugin\PluginSystem::getInstance();
$system->registerPlugin( $plugin );
}

function install_plugin( $name )
{
$system = \Framework\Plugin\PluginSystem::getInstance();
$system->installPlugin( $name );
}

function activate_plugin( $name )
{
$system = \Framework\Plugin\PluginSystem::getInstance();
$system->activatePlugin( $name );
}

function deactivate_plugin( $name )
{
$system = \Framework\Plugin\PluginSystem::getInstance();
$system->deactivatePlugin( $name );
}
