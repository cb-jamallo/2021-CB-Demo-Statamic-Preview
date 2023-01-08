<?php 
    
namespace App\Classes;

// Laravel Classes

// Statamic Classes

// Custom Classes
use App\Classes\ToastClass as ToastClass;



class SchemaReportClass
{
    private const ERROR_SCHEMA_MISSING = 'Faile to initialize for SchemaReportClass due to missing schema';

    public $schema = null;

    public function __construct( $_ARGS )
    {

        if ( !in_array( 'schema', $_ARGS ) ) throw new \Exception( 
            sprintf( 
                $this::ERROR_SCHEMA_WEBSITE_FILESYSTEM_CLASS_SCHEMA_MISSING,
                $this->schema['websiteBuild']['event']['entry']->slug(),
            )
        );

        $this->schema = $_ARGS['schema'];
    }

    private function reportWebsiteBuildTree()
    {
       // return print_r( $this->schem['websiteBuild'][''], false );
    }

}