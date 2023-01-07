<?php 
    
namespace App\Classes;

// Laravel Classes
use Symfony\Component\Yaml\Yaml;

// Statamic Classes
use Statamic\Filesystem\Manager as FileSystemManager;
use Statamic\Facades\Blueprint as BlueprintManager;
use Statamic\Fields\BlueprintRepository as BlueprintRepository;
use Statamic\Yaml\Yaml as YamlManager;

// Custom Classes
use App\Classes\ToastClass as ToastClass;



class FileManagerBlueprints
{

    protected $blueprint = null;

    public function __construct( )
    {

    }

    // MANUALLY MAKE A UNIQUE COLLECTION USING A SPECIFIED BLUEPRINT
    // https://github.com/statamic/cms/blob/3.2/src/Facades/Collection.php
    // https://statamic.dev/blueprints#creating-blueprints

    // MANUALLY MAKE A UNIQUE ENTRY IN THE COLLECTIONCOLLECTION
    // https://statamic.dev/extending/data#creating-data

}