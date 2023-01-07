<?php 
    
namespace App\Classes;

// Laravel Classes
use Symfony\Component\Yaml\Yaml;
use ZipArchive;

// Statamic Classes
use Statamic\Filesystem\Manager as FileSystemManager;

// Custom Classes
use App\Classes\ToastClass as ToastClass;



class FileSystemClass
{
    private const ERROR_SCHEMA_WEBSITE_FILESYSTEM_CLASS_SCHEMA_MISSING = 'Faile to initialize for Filesystem class due to missing schema';
    private const ERROR_SCHEMA_WEBSITE_FILESYSTEM_INIT = 'Failed to initialize for the Filesystem for %s';

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

    public function filePathGenerate( $_ARGS = null )
    {
        $filePath = $_ARGS['filePath'];
        $filePathParts = explode( '/', $filePath );
        $fileStorageDisk = $_ARGS['fileStorageDisk'];
        
        // Loop
        foreach( $filePathParts as $filePathIndex=>$filePathSubstring )
        {
            // Handle as File
            if ( str_contains( $filePathSubstring, '.' ) )
            {
                if ( !$fileStorageDisk->exists( $filePathSubstring ) )
                {
                    if ( !$fileStorageDisk->put( $filePathSubstring ) ) throw new \Exception( 'Failed to create the file ' . $filePath );   
                }
                else
                {
                    if ( !$fileStorageDisk->put( $filePathSubstring, $filePathSubstring ) ) throw new \Exception( 'Failed to update the file ' . $filePath );
                }
            }
            // Handle as Directory
            else
            {
                if ( !$fileStorageDisk->exists( $filePathSubstring ) )
                {
                    if ( !$fileStorageDisk::makeDirectory( $filePathSubstring ) ) throw new \Exception( 'Failed to create the directory ' . $filePathSubstring );   
                }
            }
        }
    }

    public function fileZipExtractTo ( $_ARGS = null ) {
        
        $zip = new ZipArchive();
        $zipArchived = false;

        if ( !$_ARGS['zipOpenPath'] || !$_ARGS['zipSavePath'] ) throw new \Exception( 'No Zip Archive could be extracted' );
        
        try
        {
            if ( $zip->open( $_ARGS['zipOpenPath'] ) )
            {
                $zip->extractTo( $_ARGS['zipSavePath'] );
                $zip->close();
                $zipArchived = true;
            }
        }
        catch(\Exception $_error )
        {
            throw new \Exception( 'No Zip Archive could be extracted due to the error ' . $_error->message() );
        }

        return $zipArchived;
    }

    public function fileZipCompressTo ( $_ARGS )
    {

        // Path To Existing Zip or New Zip
        // Files To Add, with names & extensions
        // Zip Name
        // Close
    }

    public function fileReplicateInit( $_replicate )
    {
        if ( !in_array( $_replicate, $this->schema['websiteBuild']['replicate'] ) ) return;
    }

}