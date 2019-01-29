<?php

namespace Alzundaz\ModuleManager\Services;

use Alzundaz\NitroPHP\Services\ConfigHandler;
use Alzundaz\NitroPHP\BaseClass\Singleton;


class ModuleManager extends Singleton
{
    public function createModule()
    {

    }

    public function addModule($enabled = false)
    {

    }

    /**
     * Update module.json module list with installed modules
     *
     * @return void
     */
    public function listInstalledModule():void
    {
        $configHandler = ConfigHandler::getInstance();
        $modules = $configHandler->loadJsonConfig(ROOT_DIR.'/Config/', 'module.json');
        $raw_files = scandir( ROOT_DIR.'/Module/' );
        foreach($raw_files as $file){
            if ($file != '.' && $file != '..') {
                $data = $configHandler->loadJsonConfig(ROOT_DIR.'/Module/'.$file.'/Config/');
                if ( !array_key_exists($file, $modules) ){
                    $data['enabled'] = false;
                    $data['path'] = 'Module/'.$file;
                }
                array_replace($modules[$file], $data);
            }
        }
        $configHandler->setConfig(ROOT_DIR.'/Config/module.json', $modules);
    }
}