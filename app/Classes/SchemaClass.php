<?php 
    
namespace App\Classes;

// Laravel Classes
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;
use File;
use ZipArchive;

// Statamic Classes
use Statamic\Filesystem\Manager as FileSystemManager;
use Statamic\Facades\Blueprint as BlueprintManager;
use Statamic\Fields\BlueprintRepository as BlueprintRepository;
use Statamic\Yaml\Yaml as YamlManager;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Facades\Stache;
use Statamic\Structures\NavTree;
use Statamic\Stache\Stores\CollectionTreeStore;

// Custom Classes
use App\Classes\ToastClass;
use App\Classes\TagClass;
use App\Classes\ShortcodeClass;
use App\Classes\SchemaNavigationClass;
use App\Classes\GithubClass;



class SchemaClass
{

    private const ERROR_SCHEMA_WEBSITE_INIT = '%s';
    private const ERROR_SCHEMA_WEBSITE_CONTROLLER_INIT = '%s';
    private const ERROR_SCHEMA_INIT_MISSING_ENTRY_DATA = 'Failed due to missing entry data. Choose a build target.';
    private const ERROR_SCHEMA_WEBSITE_PARENT_ROOT_TITLE = 'Failed due to missing website parent root title.';
    
    private const ERROR_SCHEMA_SLUG_MISMATCH = 'One or more Website and WebsiteController Slug values do not match or is missing.';
    private const ERROR_SCHEMA_ID_MISSING = 'One or more Template [Website: %s,  Website Controller: %s] values is missing.';
    private const ERROR_SCHEMA_PUBLISHED_MISSING = 'One or more Template Published [Website: %s,  Website Controller: %s] value is missing.';
    private const ERROR_SCHEMA_STATUS_MISSING = 'One or more Template Status [Website: %s,  Website Controller: %s] value is missing.';

    private const ERROR_SCHEMA_BUILD_ID_MISSING = 'Website/Controller ( %s / %s ) id missing.';
    private const ERROR_SCHEMA_BUILD_PUBLISH_MISMATCH = 'Website/Controller ( %s / %s ) published mismatch.';
    private const ERROR_SCHEMA_BUILD_PUBLISH_TARGET_MISSING = 'Website (%s) publish target missing.';
    private const ERROR_SCHEMA_BUILD_STATUS_MISMATCH = 'Website/Controller ( %s / %s ) status mismatch.';
    private const ERROR_SCHEMA_BUILD_VERSION_MISSING = 'WebsiteController (%s) version missing.';
    private const ERROR_SCHEMA_BUILD_SLUG_MISMATCH = 'Website/Controller ( %s / %s ) slug mismatch.';
    private const ERROR_SCHEMA_BUILD_TITLE_MISSING = 'Website ( %s ) title missing.';
    private const ERROR_SCHEMA_BUILD_HOST_MISSING = 'WebsiteController ( %s ) host missing.';
    private const ERROR_SCHEMA_BUILD_PROTOCOL_MISSING = 'WebsiteController ( %s ) protcol missing.';
    private const ERROR_SCHEMA_BUILD_PROTOCOL_BASE_MISSING = 'WebsiteController ( %s ) protcol or (%s) base missing.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_MISSING = 'Website and/or WebsiteController build template missing values.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_EXT_MISMATCH = 'Website/WebsiteController build template as mismatch (%s / %s).';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_AS_MISSING = 'Website/WebsiteController build template did not find a match.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_AS_DOCTYPE_MISSING = 'Website/Controller build template doctype is missing.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_AS_HTML_MISSING = 'Website/Controller build template html is missing.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_AS_HEAD_MISSING = 'Website/Controller build template head is missing.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_AS_HEAD_TITLE_MISSING = 'Website/Controller build template head title is missing.';
    private const ERROR_SCHEMA_BUILD_TEMPLATE_AS_BODY_MISSING = 'Website/Controller build template body is missing.';

    private const ERROR_SCHEMA_REPLICATE_PACKAGE = 'Website/Controller host package zip could not be opened.';
    private const ERROR_SCHEMA_REPLICATE_PAGE_MISSING = 'Website page replication required and is not selected.';


    public $perfStopwatchStart = null;
    public $perfStopwatchEnd = null;
    public $perfStopwatchFinal = null;
    
    public $toastClass = null;

    public $event = null;

    public $eventDate = null;

    public $schema = null;

    public $shortcodeClass = null;

    public $tagClass = null;

    public function __construct( $_ARGS = null )
    {
        
        $this->toastClass = new ToastClass(array(
            'toastMessage' => 'Build Schema Initialized : [toastMessage]',
            'toastDuration' => 5000,
        ));

        $this->event = $_ARGS['event'];
        $this->eventDate = date('Y-m-dTH:i:sP', time());

        $this->tagClass = new TagClass();

        $this->shortcodeClass = new ShortcodeClass();

        $this->schemaNavigationClass = new SchemaNavigationClass();
    }

    /*
        - Build Schema Array
        - Parse Event base data
        - Parse Event collection website || websiteController
    */
    public function initSchema( $_ARGS = null )
    {

        $this->schema = array(
            'website' => [],
            'websiteController' => [],
            'websiteBuild' => [],
            // 'websiteForm' => [], // TBD
        );

        // Initialize websiteBuild
        $this->schema['websiteBuild']['event'] = $_ARGS['event'] ?? $this->event;
        $this->schema['websiteBuild']['blueprint'] = $this->schema['websiteBuild']['event']->entry->blueprint()->handle();
        $this->schema['websiteBuild']['replicate'] = $this->schema['websiteBuild']['event']->entry->replicate;
        $this->schema['websiteBuild']['target'] = $this->schema['websiteBuild']['event']->entry->target;
        
        //  Handle Build on Website Collection
        if ( $this->schema['websiteBuild']['blueprint'] === 'website' )
        {

            // Set website data normally
            $this->schema['website']['entry'] = $this->event->entry;
            $this->schema['website']['blueprint'] = $this->schema['website']['entry']->blueprint()->handle();
            $this->schema['website']['data'] = $this->schema['website']['entry']->data();
            $this->schema['website']['dataAugmented'] = $this->schema['website']['entry']->toAugmentedArray();
            $this->schema['website']['collection'] = $this->schema['website']['dataAugmented']['collection'];

            // Set websiteController data dynamically based on slug
            $slug = $this->parseWebsiteRoot( $this->schema['website']['entry'] )->slug();
            $websiteControllerCollection = Entry::whereInCollection( [ 'website_controller' ] );
            $websiteControllerCollection = array_filter( $websiteControllerCollection->toArray(), function( $item ) use ( $slug ) {
                if ( $item->slug() === $slug ) return $item;
            })[0];

            $this->schema['websiteController']['entry'] = $websiteControllerCollection;
            $this->schema['websiteController']['blueprint'] = $this->schema['websiteController']['entry']->blueprint()->handle();
            $this->schema['websiteController']['data'] = $this->schema['websiteController']['entry']->data();
            $this->schema['websiteController']['dataAugmented'] = $this->schema['websiteController']['entry']->toAugmentedArray();
            $this->schema['websiteController']['collection'] = $this->schema['websiteController']['dataAugmented']['collection'];
            
        }
        
        //  Handle Build on WebsiteController Collection
        if ( $this->schema['websiteBuild']['blueprint'] === 'website_controller' )
        {

            // Set websiteController data normally
            // Set website data normally
            $this->schema['websiteController']['entry'] = $this->event->entry;
            $this->schema['websiteController']['blueprint'] = $this->schema['websiteController']['entry']->blueprint()->handle();
            $this->schema['websiteController']['data'] = $this->schema['websiteController']['entry']->data();
            $this->schema['websiteController']['dataAugmented'] = $this->schema['websiteController']['entry']->toAugmentedArray();
            $this->schema['websiteController']['collection'] = $this->schema['websiteController']['dataAugmented']['collection'];

            $slug = $this->schema['websiteController']['entry']->slug();
            
            // Bug fix note: wrap in array_values to re-index at 0 
            $websiteCollection = Entry::whereInCollection( [ 'website' ] );
            $websiteCollection = array_values( array_filter( $websiteCollection->toArray(), function( $item ) use ( $slug ) {
                if ( $item->slug() === $slug ) return $item;
            }))[0];

            $this->schema['website']['entry'] = $websiteCollection;
            $this->schema['website']['blueprint'] = $this->schema['website']['entry']->blueprint()->handle();
            $this->schema['website']['data'] = $this->schema['website']['entry']->data();
            $this->schema['website']['dataAugmented'] = $this->schema['website']['entry']->toAugmentedArray();
            $this->schema['website']['collection'] = $this->schema['website']['dataAugmented']['collection'];
            
        }

        // Handle error if no website and websiteController slug match found.
        if ( $this->parseWebsiteRoot( $this->schema['website']['entry'] )->slug() !== $this->schema['websiteController']['entry']->slug() ) throw \Exception( $this::ERROR_SCHEMA_SLUG_MISMATCH );

    }

    public function initWebsite()
    {

        try 
        {
            // Check for event/entry.
            if ( !$this->event ) throw new \Exception( $this::ERROR_SCHEMA_INIT_MISSING_ENTRY_DATA );

            $this->perfStopwatchStart = microtime(true);

            // Init schema
            $this->initSchema();
            
            // Set schema array
            $this->parseWebsiteController();
            $this->parseWebsite();
            
            // Set Build Core
            $this->buildIdSet();
            $this->buildPublishedSet();
            $this->buildStatusSet();
            
            // Set Build Domain
            $this->buildSlugSet();
            $this->buildTitleSet();
            $this->buildHostSet();
            $this->buildBaseSet();
            $this->buildCanonicalSet();

            // Set Build Metadata
            $this->buildMetadataSet();
            
            // TESTING SHORTCODES
            // $a = $this->shortcodeClass->all('[one]One[/one] <h1> Here\'s a headline! </h1>  [two] Two [three] Three [four] Four [/four] [/three] [/two]. ');
            // $t = $this->shortcodeClass->findAndReplace([
            //     'path' => '[website.domain.slug]',
            //     'array' => $this->schema
            // ]);

            // Set Build Navigation
            $this->buildNavigationSet();

            // Set Build Template:
            $this->buildTemplateSet();
            
            $this->perfStopwatchEnd = microtime(true);
            $this->perfStopwatchFinal =  $this->perfStopwatchEnd - $this->perfStopwatchStart;

        } 
        catch (\Exception $_error)
        {
            
            $errorMessage = sprintf( 
                $this::ERROR_SCHEMA_WEBSITE_INIT,
                'Failed to init for the Website '. $this->schema['website']['domain']['slug'] . ': <br />' . $_error->getMessage(),
            );

            // ToastClass::log(array(
            //     'toastType' => 'error',
            //     'toastMessage' => $errorMessag,
            //     'toastDuration' => 4000
            // ));

            throw new \Exception ( $errorMessage );

        }

        return $this->schema;

    }

    public function initWebsiteController()
    {
        try
        {

            // Check for entry.
            if ( !$this->event ) throw new \Exception( $this::ERROR_SCHEMA_INIT_MISSING_ENTRY_DATA );

            $this->perfStopwatchStart = microtime(true);

            // Init Website ( Parses Schema for Website & WebsiteController )
            $this->initWebsite();

            $this->perfStopwatchEnd = microtime(true);
            $this->perfStopwatchFinal =  $this->perfStopwatchEnd - $this->perfStopwatchStart;

        } 
        catch (\Exception $_error)
        {
            
            ToastClass::log(array(
                'toastType' => 'error',
                'toastMessage' => sprintf( 
                    $this::ERROR_SCHEMA_WEBSITE_CONTROLLER_INIT,
                    'Failed to init for the WebsiteController '. $this->schema['websiteController']['domain']['slug'] . ': <br />' . $_error->getMessage(),
                ),
                'toastDuration' => 4000
            ));

            throw new \Exception( $_error->getMessage() );

        }

        return $this->schema;
    }

    private function parseWebsite()
    {
        // Core
        $this->schema['website']['id'] = $this->schema['website']['entry']->id(); // UUID
        $this->schema['website']['parent'] = $this->schema['website']['entry']->parent();
        $this->schema['website']['root'] = $this->parseWebsiteRoot( $this->schema['website']['entry'] );
        $this->schema['website']['private'] = $this->schema['website']['dataAugmented']['private'];
        $this->schema['website']['status'] = $this->schema['website']['entry']->status();
        $this->schema['website']['published'] = $this->schema['website']['entry']->published();
        $this->schema['website']['publishedDate'] = $this->eventDate;

        // Replicate
        $this->schema['website']['replicate'] = $this->parseDataKey('website', 'replicate'); // Required Per-publish...
        $this->schema['website']['target'] = $this->parseDataKey('website', 'target'); // Required Per-publish...
        
        // Domain
        $this->schema['website']['domain'] = [
            'slug' => $this->schema['website']['entry']->slug(), // Auto generated via lowercase-hyphenated Title
            'title' => $this->parseDataKey('website', 'title'), // Title
            'title_alias' => $this->parseDataKey('website', 'title_alias'), // Title Alias (If needed alternative for display)
        ];

        // Template - Only one per page.
        $this->schema['website']['template'] = $this->parseDataKey('website', 'template', true)[0];

        // Metadata
        $this->schema['website']['metadata'] = [
            'meta' => $this->parseDataKey('website', 'meta')?? [],
            'link' => $this->parseDataKey('website', 'link') ?? []
        ];

        // Code
        $this->schema['website']['code'] = $this->parseDataKey('website', 'code', true);

        // Script
        $this->schema['website']['script'] = $this->parseDataKey('website', 'script', true);

        // Style
        $this->schema['website']['style'] = $this->parseDataKey('website', 'style', true);

        // Image
        $this->schema['website']['image'] = $this->parseDataKey('website', 'image', true);

        // Video
        $this->schema['website']['video'] = $this->parseDataKey('website', 'video', true);

        // Font
        $this->schema['website']['font'] = $this->parseDataKey('website', 'font', true);

        // Document
        $this->schema['website']['document'] = $this->parseDataKey('website', 'document', true);

        // Clean-up
        unset(
            $this->schema['website']['data'],
            $this->schema['website']['dataAugmented'],
            $this->schema['website']['collection']
        );

    }

    private function parseWebsiteRoot( $_ARGS )
    {
        if ( !$_ARGS ) throw new \Exception( $this::ERROR_SCHEMA_WEBSITE_PARENT_ROOT_TITLE );

        // Return as root if no parent
        if ( !$_ARGS->toAugmentedArray()['parent'] ) return $_ARGS;

        return $this->parseWebsiteRoot( Entry::find( $_ARGS->toAugmentedArray()['parent']->id() ) );

    }

    private function parseWebsiteController()
    {     
        try
        {   
            
            // Core
            $this->schema['websiteController']['id'] = $this->schema['websiteController']['entry']->id(); // UUID
            $this->schema['websiteController']['parent'] = $this->schema['websiteController']['entry']->parent();
            $this->schema['websiteController']['root'] = $this->parseWebsiteRoot( $this->schema['websiteController']['entry'] );
            $this->schema['websiteController']['private'] = $this->schema['websiteController']['dataAugmented']['private'];
            $this->schema['websiteController']['status'] = $this->schema['websiteController']['entry']->status();
            $this->schema['websiteController']['published'] = $this->schema['websiteController']['entry']->published();
            $this->schema['websiteController']['publishedDate'] = $this->eventDate;

            // Replicate
            $this->schema['websiteController']['replicate'] = $this->parseDataKey( 'websiteController', 'replicate' ); //$this->schema['websiteController']['dataAugmented']['replicate']->raw();
            $this->schema['websiteController']['target'] = $this->parseDataKey( 'websiteController', 'target' ); //$this->schema['websiteController']['dataAugmented']['target']->raw();
            
            // Domain
            $this->schema['websiteController']['domain'] = [
                'slug' => $this->schema['websiteController']['entry']->slug(), // Auto generated via lowercase-hyphenated Title
                'title' => $this->parseDataKey('websiteController', 'title'), // Title
                'host' => $this->parseDataKey('websiteController', 'host', true)[0],
            ];
            
            // Template(s) - more than one optional
            $this->schema['websiteController']['template'] = $this->parseDataKey('websiteController', 'template', true);

            // Metadata
            $this->schema['websiteController']['metadata'] = [
                'meta' => $this->parseDataKey('websiteController', 'meta')?? [],
                'link' => $this->parseDataKey('websiteController', 'link') ?? []
            ];

            // Script
            $this->schema['websiteController']['script'] = $this->parseDataKey('websiteController', 'script', true);

            // Style
            $this->schema['websiteController']['style'] = $this->parseDataKey('websiteController', 'style', true);

            // Image
            $this->schema['websiteController']['image'] = $this->parseDataKey('websiteController', 'image', true);

            // Video
            $this->schema['websiteController']['video'] = $this->parseDataKey('websiteController', 'video', true);

            // Font
            $this->schema['websiteController']['font'] = $this->parseDataKey('websiteController', 'font', true);

            // Document
            $this->schema['websiteController']['document'] = $this->parseDataKey('websiteController', 'document', true);

            // Code
            $this->schema['websiteController']['code'] = $this->parseDataKey('websiteController', 'code', true);

            // Clean-up
            unset(
                $this->schema['websiteController']['data'],
                $this->schema['websiteController']['dataAugmented'],
                $this->schema['websiteController']['collection']
            );

        }
        catch(\Exception $_error)
        {
            ToastClass::log(array(
                'toastType' => 'error',
                'toastMessage' => sprintf( 
                    $this::ERROR_SCHEMA_WEBSITE_INIT,
                    $_error->getMessage() ?? 'Failed to init parseWebsiteControll for the Website '. $this->schema['website']['slug'],
                ),
                'toastDuration' => 4000
            ));
        }
    }

    private function parseDataKey( $_collection, $_collectionKey, $_collectionTarget = false )
    {
        $collectionKeyTarget = $this->schema[ 'websiteBuild' ]['target'] . '-' . $_collectionKey;
        
        if ( isset( $this->schema[ $_collection ][ 'data' ][ $collectionKeyTarget ] ) ) $collectionTargetPath = $this->schema[ $_collection ][ 'data' ][ $collectionKeyTarget ];
        if ( isset( $this->schema[ $_collection ][ 'data' ][ $_collectionKey ] ) ) $collectionTargetPath = $this->schema[ $_collection ][ 'data' ][ $_collectionKey ];
        
        if ( !isset( $collectionTargetPath ) ) return null;

        return $collectionTargetPath;
    }

    // Numeric array collections w/ arrays containing a collection w/ Uid fields as keys
    private function parseDataUid( $_arrayA, $_arrayB )
    {
        $arrayA = $_arrayA ?? [];
        $arrayB = $_arrayB ?? [];

        $arrayA = $this->parseDataUidArrayToAssoc( $arrayA );
        $arrayB = $this->parseDataUidArrayToAssoc( $arrayB );

        if ( !$arrayA ) return $arrayB;
        if ( !$arrayB ) return $arrayA;
        if ( $arrayA && $arrayB ) 
        {    
            $array = $arrayA;

            foreach( $arrayB as $_key => $_value )
            {
                // Get Unique array
                if ( !array_key_exists( strtolower( $_key ), $array ) ) $array[ strtolower( $_key ) ] = $_value;
            }

            return $array;
        };
        
    }

    private function parseDataUidArrayToAssoc( $_array )
    {

        $assocArray = [];
        $assocArrayKey = [];
        
        // Handle null or empty
        if ( !$_array || empty( $_array ) ) return $assocArray;

        foreach( $_array as $_key => $_value )
        {
            // Handle skip of disabled items
            if ( !$_value['enabled'] ) continue;

            foreach( $_value as $_key2 => $_value2 )
            {
                if ( strtolower( $_key2 ) === 'uid' ) 
                {
                    $assocArrayKey = $_value2;
                    $assocArray[ strtolower( $assocArrayKey ) ] = [];
                    continue;
                }

                $assocArray[ strtolower( $assocArrayKey ) ][ strtolower( $_key2 ) ] = $_value2;
            }
            
        }

        return $assocArray;
    }

    /**
    * Build Get/Set 
    */

    /**
    * Website & WebsiteController id. 
    */
    protected function buildIdSet()
    {
        if ( empty( $this->schema['website']['id'] ) || empty( $this->schema['websiteController']['id'] ) ) throw new \Exception( 
            sprintf( 
                $this::ERROR_SCHEMA_BUILD_ID_MISSING,
                $this->schema['website']['id'],
                $this->schema['websiteController']['id']
            ));
        
        return $this->schema['websiteBuild']['id'] = $this->schema['website']['id'];
    }

    /**
    * WebsiteController status value of 'published' required. 
    */
    protected function buildStatusSet()
    {
        if ( $this->schema['website']['status'] !== 'published' || $this->schema['websiteController']['status'] !== 'published' ) throw new \Exception( 
            sprintf( 
                $this::ERROR_SCHEMA_BUILD_STATUS_MISMATCH,
                $this->schema['website']['status'],
                $this->schema['websiteController']['status']
            ));
        
        return $this->schema['websiteBuild']['status'] = $this->schema['website']['status']; 
    }

    /**
    * WebsiteController published bool of TRUE required. 
    */
    protected function buildPublishedSet()
    {
        if ( !$this->schema['websiteController']['published'] || !$this->schema['websiteController']['published'] ) throw new \Exception( 
            sprintf( 
                $this::ERROR_SCHEMA_BUILD_PUBLISH_MISMATCH,
                $this->schema['website']['published'],
                $this->schema['websiteController']['published']
            ));

        return $this->schema['websiteBuild']['published'] = $this->schema['website']['published'];
    }

    /**
    * WebsiteController Host bool of TRUE required. 
    */
    protected function buildHostSet()
    { 
        if ( !$this->schema['websiteController']['domain']['host'] ) throw new \Exception( 
            sprintf(
                $this::ERROR_SCHEMA_BUILD_HOST_MISSING,
                $this->schema['websiteBuild']['domain']['slug']
            )
        );

        return $this->schema['websiteBuild']['domain']['host'] = $this->schema['websiteController']['domain']['host'];
    }


    /**
    * Website && WebsiteController slug value match required. 
    */
    protected function buildSlugSet()
    {            
        if ( empty( $this->schema['website']['domain']['slug'] ) ||
             empty( $this->schema['websiteController']['domain']['slug'] ) ) throw new \Exception( 
                sprintf( 
                    $this::ERROR_SCHEMA_BUILD_SLUG_MISMATCH,
                    $this->schema['website']['domain']['slug'],
                    $this->schema['websiteController']['domain']['slug']
                ));   
        
        // Handle env slug - always set by unique controller
        $this->schema['websiteBuild']['domain']['slug'] = $this->schema['websiteController']['domain']['slug'];
        
        return;
    }

    /**
    * WebsiteBuild title setter...
    * WebsiteBuild title value (defaults to Title Alias if exists)... 
    */
    protected function buildTitleSet()
    { 
        
        if ( empty( $this->schema['website']['domain']['title'] ) ) throw new \Exception( 
            sprintf( 
                $this::ERROR_SCHEMA_BUILD_TITLE_MISSING,
                $this->schema['website']['domain']['title'],
            )); 

        
        // Override w/ title alias if not empty...
        return $this->schema['websiteBuild']['domain']['title'] = ( !empty( $this->schema['website']['domain']['title_alias'] ) ) 
            ? $this->schema['website']['domain']['title_alias']
            : $this->schema['website']['domain']['title'];
    }

    /**
    * ... 
    */

    protected function buildBaseSet()
    { 
        if ( !$this->schema['websiteController']['domain']['host']['protocol'] || !$this->schema['websiteController']['domain']['host']['base'] ) throw new \Exception( 
            sprintf(
                $this::ERROR_SCHEMA_BUILD_PROTOCOL_BASE_MISSING,
                $this->schema['websiteController']['domain']['host']['protocol'],
                $this->schema['websiteController']['domain']['host']['base']
            )
        );

        // Override w/ title alias if not empty...
        return $this->schema['websiteBuild']['domain']['host']['base'] = sprintf( 
            '%s://%s', 
            $this->schema['websiteController']['domain']['host']['protocol'], 
            $this->schema['websiteController']['domain']['host']['base'] );
    }

    protected function buildCanonicalSet()
    { 
        if ( !$this->schema['websiteController']['domain']['host']['protocol'] || !$this->schema['websiteController']['domain']['host']['base'] ) throw new \Exception( 
            sprintf(
                $this::ERROR_SCHEMA_BUILD_PROTOCOL_BASE_MISSING,
                $this->schema['websiteController']['domain']['host']['protocol'],
                $this->schema['websiteController']['domain']['host']['base']
            )
        );

        return $this->schema['websiteBuild']['domain']['host']['canonical'] = sprintf( 
            '%s://%s', 
            $this->schema['websiteController']['domain']['host']['protocol'], 
            $this->schema['websiteController']['domain']['host']['base'] );
    }

    protected function buildMetadataSet()
    {
        $this->schema['websiteBuild']['metadata'] = array( 
            'meta' => $this->parseDataUid( $this->schema['website']['metadata']['meta'], $this->schema['websiteController']['metadata']['meta'] ),
            'link' => $this->parseDataUid( $this->schema['website']['metadata']['link'], $this->schema['websiteController']['metadata']['link'] )
        );
    }

    protected function buildNavigationSet()
    {
        $this->schema = $this->schemaNavigationClass->init([
            'schema' => $this->schema
        ]);

        $this->schema['websiteBuild']['navigation'] = $this->schema['website']['navigation'];

        $this->schema['websiteBuild']['navigation']['json'] = json_encode( $this->schema['websiteBuild']['navigation']['tree'], JSON_UNESCAPED_SLASHES );

    }

    protected function buildTemplateSet()
    {

        // Validate existing template
        if ( !$this->schema['website']['template'] || !$this->schema['websiteController']['template'] ) throw new \Exception( 
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_MISSING
        );

        // Get the matching template
        array_filter(
            $this->schema['websiteController']['template'],
            function( $websiteControllerTemplate )
            {
                if ( strtolower( $websiteControllerTemplate['uid'] ) === strtolower( $this->schema['website']['template']['uid'] ) ) return $websiteControllerTemplate;
            }
        );

        // Validate matching template found
        if ( count( $this->schema['websiteController']['template'] ) !== 1 ) throw new \Exception(
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_AS_MISSING
        );

        // Validate matching template as ext, name, and path
        if ( $this->schema['website']['template']['ext'] !== $this->schema['websiteController']['template'][0]['ext']
        || $this->schema['website']['template']['name'] !== $this->schema['websiteController']['template'][0]['name']
        // || $this->schema['website']['template']['path'] !== $this->schema['websiteController']['template'][0]['path']
         ) throw new \Exception( 
            sprintf(
                $this::ERROR_SCHEMA_BUILD_TEMPLATE_EXT_MISMATCH,
                $this->schema['website']['template']['ext'],
                $this->schema['websiteController']['template'][0]['ext'] 
            )
        );

        // Reduce the websiteController array to ONLY the matching as/uid type w/ website page requested
        $this->schema['websiteController']['template'] = $this->schema['websiteController']['template'][0];

        $this->schema['websiteBuild']['template'] = [];
        $this->schema['websiteBuild']['template']['enabled'] = $this->schema['website']['template']['enabled'];
        $this->schema['websiteBuild']['template']['uid'] = $this->schema['website']['template']['uid'];
        $this->schema['websiteBuild']['template']['path'] = $this->schema['website']['template']['path'];
        $this->schema['websiteBuild']['template']['name'] = $this->schema['website']['template']['name'];
        $this->schema['websiteBuild']['template']['ext'] = $this->schema['website']['template']['ext'];

        $this->buildTemplateDoctypeSet();
        $this->buildTemplateHtmlSet();
        $this->buildTemplateHeadSet();
        $this->buildTemplateHeadTitleSet();
        $this->buildTemplateHeadMetaSet();
        $this->buildTemplateHeadStyleSet();
        $this->buildTemplateHeadScriptSet();
        $this->buildTemplateBodySet();
        
        // Handle HTML
        if (  $this->schema['websiteBuild']['template']['ext'] === 'html' ) $this->buildTemplateOutputHtmlSet();

        // Handle Svelte/kit
        if ( $this->schema['websiteBuild']['template']['ext'] === 'svelte' ) $this->buildTemplateOutputSvelteSet();
        
    }

    protected function buildTemplateDoctypeSet()
    {
        if ( 
            !$this->schema['website']['template']['doctype'] && 
            !$this->schema['websiteController']['template']['doctype']
        ) throw new \Exception( 
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_AS_DOCTYPE_MISSING
        );

        $websiteController = $this->tagClass->get([
            'regexTag' => ['doctype'],
            'regexContent' => $this->schema['websiteController']['template']['doctype']['code'] ?? ''
        ])[0];

        $website = $this->tagClass->get([
            'regexTag' => ['doctype'],
            'regexContent' => $this->schema['website']['template']['doctype']['code'] ?? ''
        ])[0];
        
        return $this->schema['websiteBuild']['template']['doctype'] = [
            'tag' => $websiteController['tag'],
            'type' => $websiteController['type'],
            'attribute' => ( $websiteController['attribute'] ) ? $websiteController['attribute'] : $website['attribute'],
            'modifier' => ( $websiteController['modifier'] ) ? $websiteController['modifier'] : $website['modifier'],
            'outer' => ( $websiteController['outer'] ) ?  $websiteController['outer'] : $website['outer'],
            'inner' => ( $websiteController['inner'] ) ?  $websiteController['inner'] : $website['inner'],
            'output' => (function() use ( $website, $websiteController ) {

                if ( str_contains( $websiteController['outer'], '[website.template.doctype]' ) ) return str_replace( '[website.template.doctype]', $website['inner'], $websiteController['outer'] );
                if ( str_contains( $website['outer'], '[websitecontroller.template.doctype]' ) ) return str_replace( '[websitecontroller.template.doctype]', $websiteController['inner'], $website['outer'] );
                if ( !empty( $websiteController['outer'] ) ) return $websiteController['outer'];
                if ( !empty( $website['outer'] ) ) return $website['outer'];
                // Need tag...
                if ( !empty( $websiteController['inner'] ) ) return $websiteController['inner'];
                if ( !empty( $website['inner'] ) ) return $website['inner'];
                return '';

            })( $website, $websiteController )
        ];
    }

    protected function buildTemplateHtmlSet()
    {
        // Require at least one doctype declaration
        if ( 
            !$this->schema['website']['template']['html'] && 
            !$this->schema['websiteController']['template']['html']
        ) throw new \Exception( 
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_AS_HTML_MISSING
        );

        $websiteController = $this->tagClass->get([
            'regexTag' => ['html'],
            'regexContent' => $this->schema['websiteController']['template']['html']['code'] ?? ''
        ])[0];

        $website = $this->tagClass->get([
            'regexTag' => ['html'],
            'regexContent' => $this->schema['website']['template']['html']['code'] ?? ''
        ])[0];
        
        $this->schema['websiteBuild']['template']['html'] = [
            'tag' => $websiteController['tag'],
            'type' => $websiteController['type'],
            'attribute' => ( $websiteController['attribute'] ) ?  $websiteController['attribute'] : $website['attribute'],
            'modifier' => ( $websiteController['modifier'] ) ?  $websiteController['modifier'] : $website['modifier'],
            'outer' => ( $websiteController['outer'] ) ?  $websiteController['outer'] : $website['outer'],
            'inner' => ( $websiteController['inner'] ) ?  $websiteController['inner'] : $website['inner'],
            'output' => ''
        ];

        $this->schema['websiteBuild']['template']['html']['output'] = (function() use ( $website, $websiteController ) {

            if ( str_contains( $websiteController['outer'], '[website.template.body]' ) ) return str_replace( '[website.template.body]', $website['inner'], $websiteController['outer'] );
            if ( str_contains( $website['outer'], '[websitecontroller.template.body]' ) ) return str_replace( '[websitecontroller.template.body]', $websiteController['inner'], $website['outer'] );
            if ( !empty( $websiteController['outer'] ) ) return $websiteController['outer'];
            if ( !empty( $website['outer'] ) ) return $website['outer'];
            if ( !empty( $websiteController['inner'] ) ) return $this->tagClass->parseConcatTag([ 
                'tag' => $websiteController['tag'],
                'attribute' =>  $this->schema['websiteBuild']['template']['html']['attribute'],
                'content' => $websiteController['inner']
            ]);
            if ( !empty( $website['inner'] ) ) return $this->tagClass->parseConcatTag([ 
                'tag' => $website['tag'],
                'attribute' =>  $this->schema['websiteBuild']['template']['html']['attribute'],
                'content' => $website['inner']
            ]);
            return '';

        })( $website, $websiteController );
    }

    protected function buildTemplateHeadSet()
    {
        // Require at least one doctype declaration
        if ( 
            !isset( $this->schema['website']['template']['head'] ) && 
            !isset( $this->schema['websiteController']['template']['head'] )
        ) throw new \Exception( 
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_AS_HEAD_MISSING
        );

        $websiteController = $this->tagClass->get([
            'regexTag' => ['head'],
            'regexContent' => $this->schema['websiteController']['template']['head']['code'] ?? ''
        ])[0];

        $website = $this->tagClass->get([
            'regexTag' => ['head'],
            'regexContent' => $this->schema['website']['template']['head']['code'] ?? ''
        ])[0];
        
        $this->schema['websiteBuild']['template']['head'] = [
            'tag' => $websiteController['tag'],
            'type' => $websiteController['type'],
            'attribute' => ( $websiteController['attribute'] ) ?  $websiteController['attribute'] : $website['attribute'],
            'modifier' => ( $websiteController['modifier'] ) ?  $websiteController['modifier'] : $website['modifier'],
            'outer' => ( $websiteController['outer'] ) ?  $websiteController['outer'] : $website['outer'],
            'inner' => ( $websiteController['inner'] ) ?  $websiteController['inner'] : $website['inner'],
            'output' => ''
        ];

        $this->schema['websiteBuild']['template']['head']['output'] = (function() use ( $website, $websiteController ) {

            if ( str_contains( $websiteController['outer'], '[website.template.body]' ) ) return str_replace( '[website.template.body]', $website['inner'], $websiteController['outer'] );
            if ( str_contains( $website['outer'], '[websitecontroller.template.body]' ) ) return str_replace( '[websitecontroller.template.body]', $websiteController['inner'], $website['outer'] );
            if ( !empty( $websiteController['outer'] ) ) return $websiteController['outer'];
            if ( !empty( $website['outer'] ) ) return $website['outer'];
            if ( !empty( $websiteController['inner'] ) ) return $this->tagClass->parseConcatTag([ 
                'tag' => $websiteController['tag'],
                'attribute' =>  $this->schema['websiteBuild']['template']['html']['attribute'],
                'content' => $websiteController['inner']
            ]);
            if ( !empty( $website['inner'] ) ) return $this->tagClass->parseConcatTag([ 
                'tag' => $website['tag'],
                'attribute' =>  $this->schema['websiteBuild']['template']['html']['attribute'],
                'content' => $website['inner']
            ]);
            return '';

        })( $website, $websiteController );
    }

    protected function buildTemplateHeadMetaSet()
    {   

        $metadataHtml = '';

        $metadataLink = $this->schema['websiteBuild']['metadata']['link'];
        $metadataMeta = $this->schema['websiteBuild']['metadata']['meta'];
        
        foreach( $metadataLink as $metadataLinkEntry )
        {
            if ( !array_key_exists( 'content', $metadataLinkEntry ) ) continue;
            if ( $metadataLinkEntry && $metadataLinkEntry['content'] !== '' ) $metadataHtml .= $metadataLinkEntry['content'];
        }

        foreach( $metadataMeta as $metadataMetaEntry )
        {
            if ( !array_key_exists( 'content', $metadataMetaEntry ) ) continue;
            if ( $metadataMetaEntry && $metadataMetaEntry['content'] !== '' ) $metadataHtml .= $metadataMetaEntry['content'];
        }

        $this->schema['websiteBuild']['template']['metadata'] = array(
            'link' => $metadataLink,
            'meta' => $metadataMeta,
            'output' => $metadataHtml
        );
    }

    protected function buildTemplateHeadStyleSet()
    {
        $this->schema['websiteBuild']['template']['style']['output'] = 
            ( $this->schema['websiteController']['template']['style']['code'] ?? '' )
            . ( $this->schema['website']['template']['style']['code'] ?? '' );
    }

    protected function buildTemplateHeadScriptSet()
    {
        $this->schema['websiteBuild']['template']['script']['output'] = 
            ( $this->schema['websiteController']['template']['script']['code'] ?? '' )
                . ( $this->schema['website']['template']['script']['code'] ?? '' );
    }

    protected function buildTemplateHeadTitleSet()
    {
         // Require at least one doctype declaration
         if ( 
            !isset( $this->schema['website']['template']['title'] ) && 
            !isset( $this->schema['websiteController']['template']['title'] )
        ) throw new \Exception( 
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_AS_HEAD_TITLE_MISSING
        );

        $websiteController = $this->tagClass->get([
            'regexTag' => ['title'],
            'regexContent' => $this->schema['websiteController']['template']['title']['code'] ?? ''
        ])[0];

        $website = $this->tagClass->get([
            'regexTag' => ['title'],
            'regexContent' => $this->schema['website']['template']['title']['code'] ?? ''
        ])[0];
        
        $this->schema['websiteBuild']['template']['title'] = [
            'tag' => $websiteController['tag'],
            'type' => $websiteController['type'],
            'attribute' => ( $websiteController['attribute'] ) ?  $websiteController['attribute'] : $website['attribute'],
            'modifier' => ( $websiteController['modifier'] ) ?  $websiteController['modifier'] : $website['modifier'],
            'outer' => ( $websiteController['outer'] ) ?  $websiteController['outer'] : $website['outer'],
            'inner' => ( $websiteController['inner'] ) ?  $websiteController['inner'] : $website['inner'],
            'output' => ''
        ];

        $this->schema['websiteBuild']['template']['title']['output'] = (function() use ( $website, $websiteController ) {

            if ( str_contains( $websiteController['outer'], '[website.template.title]' ) ) return str_replace( '[website.template.title]', $website['inner'], $websiteController['outer'] );
            if ( str_contains( $website['outer'], '[websitecontroller.template.title]' ) ) return str_replace( '[websitecontroller.template.title]', $websiteController['inner'], $website['outer'] );
            if ( !empty( $websiteController['outer'] ) ) return $websiteController['outer'];
            if ( !empty( $website['outer'] ) ) return $website['outer'];
            if ( !empty( $websiteController['inner'] ) ) return $this->tagClass->parseConcatTag([ 
                'tag' => $websiteController['tag'],
                'attribute' =>  $this->schema['websiteBuild']['template']['html']['attribute'],
                'content' => $websiteController['inner']
            ]);
            if ( !empty( $website['inner'] ) ) return $this->tagClass->parseConcatTag([ 
                'tag' => $website['tag'],
                'attribute' =>  $this->schema['websiteBuild']['template']['html']['attribute'],
                'content' => $website['inner']
            ]);
            return '';

        })( $website, $websiteController );
    }

    protected function buildTemplateBodySet()
    {
        // Require at least one declaration body
        if ( 
            !$this->schema['website']['template']['body'] && 
            !$this->schema['websiteController']['template']['body']
        ) throw new \Exception( 
            $this::ERROR_SCHEMA_BUILD_TEMPLATE_AS_BODY_MISSING
        );

        $websiteController = $this->tagClass->get([
            'regexTag' => ['body'],
            'regexContent' => $this->schema['websiteController']['template']['body']['code'] ?? ''
        ])[0];

        $website = $this->tagClass->get([
            'regexTag' => ['body'],
            'regexContent' => $this->schema['website']['template']['body']['code'] ?? ''
        ])[0];
        
        $this->schema['websiteBuild']['template']['body'] = [
            'tag' => $websiteController['tag'],
            'type' => $websiteController['type'],
            'attribute' => ( $websiteController['attribute'] ) ?  $websiteController['attribute'] : $website['attribute'],
            'modifier' => ( $websiteController['modifier'] ) ?  $websiteController['modifier'] : $website['modifier'],
            'outer' => ( $websiteController['outer'] ) ?  $websiteController['outer'] : $website['outer'],
            'inner' => ( $websiteController['inner'] ) ?  $websiteController['inner'] : $website['inner'],
            'output' => (function() use ( $website, $websiteController ) {

                if ( str_contains( $websiteController['outer'], '[website.template.body]' ) ) return str_replace( '[website.template.body]', $website['inner'], $websiteController['outer'] );
                if ( str_contains( $website['outer'], '[websitecontroller.template.body]' ) ) return str_replace( '[websitecontroller.template.body]', $websiteController['inner'], $website['outer'] );
                
                if ( !empty( $websiteController['outer'] ) ) return $websiteController['outer'];
                if ( !empty( $website['outer'] ) ) return $website['outer'];
                
                // Need tag...
                if ( !empty( $websiteController['inner'] ) ) return $websiteController['inner'];
                if ( !empty( $website['inner'] ) ) return $website['inner'];
                return '';

            })( $website, $websiteController )
        ];
    }

    protected function buildTemplateOutputHtmlSet()
    {
        // Append <!doctype>
        $this->schema['websiteBuild']['template']['output'] = $this->schema['websiteBuild']['template']['doctype']['output'];
        
        // Append <html>
        $this->schema['websiteBuild']['template']['output'] .= $this->schema['websiteBuild']['template']['html']['output'];
        
        // Inject <head>
        $this->schema['websiteBuild']['template']['output'] = str_replace(
            '</html>', 
            $this->schema['websiteBuild']['template']['head']['output'] . '</html>',
            $this->schema['websiteBuild']['template']['output']
        );
        
        // Inject <title>
        $this->schema['websiteBuild']['template']['output'] = str_replace(
            '<head>', 
            '<head>' . $this->schema['websiteBuild']['template']['title']['output'],
            $this->schema['websiteBuild']['template']['output']
        );

        // Inject <body>
        $this->schema['websiteBuild']['template']['output'] = str_replace(
            '</head>', 
            $this->schema['websiteBuild']['template']['style']['output'] . $this->schema['websiteBuild']['template']['script']['output'] . '</head>' . $this->schema['websiteBuild']['template']['body']['output'],
            $this->schema['websiteBuild']['template']['output']
        );
    }

    protected function buildTemplateOutputSvelteSet()
    {

        $website = $this->tagClass->get([
            'regexTag' => ['body'],
            'regexContent' => $this->schema['website']['template']['body']['code'] ?? ''
        ])[0];

        $websiteController = $this->tagClass->get([
            'regexTag' => ['body'],
            'regexContent' => $this->schema['websiteController']['template']['body']['code'] ?? ''
        ])[0];

        $this->schema['websiteBuild']['template']['body']['output'] = (function() use ( $website, $websiteController ) {

            // Handle <body> tag...
            if ( str_contains( $websiteController['outer'], '[website.template.body]' ) ) return str_replace( '[website.template.body]', $website['inner'], $websiteController['outer'] );
            if ( str_contains( $website['outer'], '[websitecontroller.template.body]' ) ) return str_replace( '[websitecontroller.template.body]', $websiteController['inner'], $website['outer'] );
            
            // Handle no <body> tag...
            if ( str_contains( $websiteController['inner'], '[website.template.body]' ) ) return str_replace( '[website.template.body]', $website['inner'], $websiteController['inner'] );
            if ( str_contains( $website['inner'], '[websitecontroller.template.body]' ) ) return str_replace( '[websitecontroller.template.body]', $websiteController['inner'], $website['inner'] );
            
            if ( !empty( $websiteController['outer'] ) ) return $websiteController['outer'];
            if ( !empty( $website['outer'] ) ) return $website['outer'];
            
            if ( !empty( $websiteController['inner'] ) ) return $websiteController['inner'];
            if ( !empty( $website['inner'] ) ) return $website['inner'];
            
            return '';

        })( $website, $websiteController );

        // Inject <body>
        $this->schema['websiteBuild']['template']['output'] = 
            $this->schema['websiteBuild']['template']['script']['output']
                . $this->schema['websiteBuild']['template']['body']['output']
                    . $this->schema['websiteBuild']['template']['style']['output'];

        // Inject <svelte:head>
        if ( !str_contains( $this->schema['websiteBuild']['template']['output'], '<svelte:head>') ) $this->schema['websiteBuild']['template']['output'] = '<svelte:head></svelte:head>' . $this->schema['websiteBuild']['template']['output'];
        
        // Inject <title>
        $this->schema['websiteBuild']['template']['output'] = str_replace( '<svelte:head>', '<svelte:head>' . $this->schema['websiteBuild']['template']['title']['output'], $this->schema['websiteBuild']['template']['output'] );
    
        // Inject <link ...> & <meta ...>
        $this->schema['websiteBuild']['template']['output'] = str_replace( '</title>', '</title>' . $this->schema['websiteBuild']['template']['metadata']['output'], $this->schema['websiteBuild']['template']['output'] );
        
    }
    

    /**
    *
    * Wesbite & WebsiteController Build & Replication 
    *
    **/
    
    public function initWebsiteReset()
    {
        $this->event->entry->set( 'replicate', 'null' );
        $this->event->entry->set( 'target', 'null' );
    }

    public function initWebsiteReplicate()
    {
        // Handle Replicate host pacakge
        $this->replicateHostPackage();

        // Handle Replicate SitemapXml
        // Force it since we're doing so from the page...
        //array_push( $this->schema['websiteBuild']['replicate'], 'sitemap');
        $this->replicateSitemapXml();

        // Handle Replicate
        $this->replicatePage();

        // Handle Replicate Code:
        $this->replicateCode();

        // Handle Replicate Asset(s))
        $this->replicateAsset( 'script' );
        $this->replicateAsset( 'style' );
        $this->replicateAsset( 'image' );
        $this->replicateAsset( 'video' );
        $this->replicateAsset( 'font' );
        $this->replicateAsset( 'document' );

        // Handle Replicate
        $this->replicateBuild();
            
    }

    public function initWebsiteControllerReset()
    {
        $this->event->entry->set( 'replicate', null );
        $this->event->entry->set( 'target', null );
    }

    public function initWebsiteControllerReplicate()
    {

        // Handle Replicate host pacakge
        $this->replicateHostPackage();

        // Handle Replicate SitemapXml
        $this->replicateSitemapXml();

        // Handle Replicate robotTxt
        $this->replicateRobotTxt();

        // Handle Replicate HumanTxt
        $this->replicateHumanTxt();

        // Handle Rreplicate SecurityTxt
        $this->replicateSecurityTxt();

        // Handle Replicate Code
        $this->replicateCode();

        // Handle Replicate Script
        $this->replicateAsset( 'script' );
        $this->replicateAsset( 'style' );
        $this->replicateAsset( 'image' );
        $this->replicateAsset( 'video' );
        $this->replicateAsset( 'font' );
        $this->replicateAsset( 'document' );

        // Handle Replicate
        $this->replicateBuild();
    
    }

    protected function buildPageRouteTree ( $_id, $_navigation, $_path = '' )
    {
        $id = $_id;
        $navigation = $_navigation['tree'] ?? $_navigation;
        $path = isset( $_navigation['tree'] ) ? $_navigation['tree']['uri'] : $navigation['uri'] ?? '/';

        if ( $id !== $navigation['id'] && array_key_exists( 'children', $navigation ) )
        {
            foreach( $navigation['children'] as $navigationChild )
            {
                return $this->buildPageRouteTree( $_id, $navigationChild, $path );
            }
        }

        return $path;
    }

    protected function buildPageRouteCleaned( $_filePath, $_fileName, $_fileExt )
    {
        $route = str_replace( '//', '/', $_filePath . '/' . str_replace( '.', '', $_fileName ) . '.' . $_fileExt );

        return $route;
    }

    protected function replicateHostPackage()
    {
        // Handle nothing when there's no explicit replication request.
        if ( $this->schema['websiteBuild']['replicate'][0] === 'null' ) return;

        $fileEnv = 'build-' . $this->schema['websiteBuild']['target'];
        $fileSlug = $this->schema['websiteBuild']['domain']['slug'];
        $filePackage = $this->schema['websiteBuild']['domain']['host']['package'];
        $filePath = explode ('/', $filePackage )[0];
        $fileName = explode ('/', $filePackage )[1];
        $fileRoot = str_replace( '//', '/', $fileSlug . '/' . $filePath . '/' );
        $fileGlobal = str_replace( '//', '/', $fileEnv . '/' . $fileSlug . '/' . $filePath );
        
        $zip = new ZipArchive();

        // Handle replicate directories & file @ path
        if ( in_array( $fileSlug, Storage::disk('assets')->directories() ) 
            && Storage::disk('assets')->has( $filePackage )
            && !Storage::disk( $fileEnv )->has( $fileSlug )
        ) 
        {
            
            // Handle zip copy
            File::copy(
                Storage::disk('assets')->path('') . $this->schema['websiteBuild']['domain']['host']['package'],
                Storage::disk( $fileEnv )->path('') . $fileName
            );


            // Handle zip open
            if ( !$zip->open( Storage::disk( $fileEnv )->path('') . $fileName, ZipArchive::CREATE ) ) throw new \Exception( $this->ERROR_SCHEMA_REPLICATE_PACKAGE );
            
            // Handle zip extract
            $zip->extractTo( Storage::disk( $fileEnv )->path('') );
            $zip->close();

            // Handle zip rename
            Storage::disk( $fileEnv )->move( 
                explode( '.', $fileName)[0], 
                $fileSlug
            );
            
            // Handle zip delete & clean-up
            Storage::disk( $fileEnv )->delete( $fileName ); // Delete .zip file
            // Storage::disk( $fileEnv )->deleteDirectory( $fileSlug ); // Delete slug directory
            Storage::disk( $fileEnv )->deleteDirectory( '__MACOSX' ); // Delete __MACOSX Directory
        }
    }

    protected function replicateSitemapXml()
    {

        // Handle no replicate of sitemap
        if ( !$this->schema['websiteBuild']['domain']['host']['sitemap'][0] && ( !in_array( 'sitemapXml', $this->schema['websiteBuild']['replicate'] ) || !in_array( 'websiteController', $this->schema['websiteBuild']['replicate'] ) ) ) return;

        $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
        $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
        $filePath = strtolower( $this->schema['websiteBuild']['domain']['host']['sitemap'][0]['path'] );
        $fileName = strtolower( $this->schema['websiteBuild']['domain']['host']['sitemap'][0]['uid'] );
        
        $fileRoot = $this->buildPageRouteCleaned( $fileSlug . '/' . $filePath, $fileName, 'xml' );
        $fileGlobal = $this->buildPageRouteCleaned( $fileEnv . '/' . $fileSlug . '/' . $filePath, $fileName, 'xml' );

        $nodeUrlSet = '<?xml version="1.0" encoding="UTF-8"?>'."\r".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">%s'."\r".'</urlset>';
        $nodeUrlSetList = '';
        $nodeUrl = "\r\t".'<url>%s%s%s%s'."\r\t".'</url>';
        $nodeLoc = "\r\t\t".'<loc>' . $this->schema['websiteBuild']['domain']['host']['canonical'].'%s</loc>'; 
        $nodeLastMod =  "\r\t\t".'<lastmod>' . $this->eventDate . '</lastmod>';
        $nodeChangeFreq = "\r\t\t".'<changefreq>' . $this->schema['websiteBuild']['domain']['host']['sitemap'][0]['frequency'] . '</changefreq>';
        $nodePriority = "\r\t\t".'<priority>' . $this->schema['websiteBuild']['domain']['host']['sitemap'][0]['priority'] . '</priority>';

        // Handle remove sitemap
        if ( in_array( $fileSlug, Storage::disk( $fileEnv )->directories() ) && Storage::disk( $fileEnv )->has( $fileRoot ) ) Storage::disk( $fileEnv )->delete( $fileRoot );

        // Handle not generating new when not active
        if ( !$this->schema['websiteBuild']['domain']['host']['sitemap'][0]['enabled'] ) return;

        // Handle build node link
        function buildSitemapLink( $_node, $_nodeUrlSetList, $_nodeUrl, $_nodeLoc, $_nodeLastMod, $_nodeChangeFreq, $_nodePriority )
        {
            
            // Handle generating when enabled
            if ( $_node['enabled'] )
            {
                $_nodeUrlSetList .= sprintf( 
                    $_nodeUrl,
                    sprintf( $_nodeLoc, empty( $_node['uri'] ) ? '/' : $_node['uri'] ),
                    $_nodeLastMod,
                    $_nodeChangeFreq,
                    $_nodePriority,
                );
            
                // Handle root children
                if ( array_key_exists( 'children', $_node ) ) 
                {
                    foreach ( $_node['children'] as $_nodeChildren )
                    {
                        return buildSitemapLink( $_nodeChildren, $_nodeUrlSetList, $_nodeUrl, $_nodeLoc, $_nodeLastMod, $_nodeChangeFreq, $_nodePriority );
                    }
                }
            }
            
            return $_nodeUrlSetList;
        }

        // Handle create sitemap
        $nodeUrlSetList = buildSitemapLink( $this->schema['websiteBuild']['navigation']['tree'], $nodeUrlSetList, $nodeUrl, $nodeLoc, $nodeLastMod, $nodeChangeFreq, $nodePriority  );

        // Handle create directories & file @ path
        Storage::disk( $fileEnv )->put(
            $fileRoot, 
            sprintf( $nodeUrlSet, $nodeUrlSetList )
        );

    }

    protected function replicateRobotTxt() 
    {
        // Handle no replicate of robotTxt
        if ( !array_key_exists( 'robotTxt', $this->schema['websiteBuild']['domain']['host'] ) || (
            !in_array( 'robotTxt', $this->schema['websiteBuild']['replicate'] ) && !in_array( 'websiteController', $this->schema['websiteBuild']['replicate'] )
        ) ) return;

        $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
        $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
        $filePath = strtolower( $this->schema['websiteBuild']['domain']['host']['robotTxt'][0]['path'] );
        $fileName = strtolower( $this->schema['websiteBuild']['domain']['host']['robotTxt'][0]['uid'] ) . '.txt';
        $fileRoot = str_replace( '//', '/', $fileSlug . '/' . $filePath . '/' );
        $fileGlobal = str_replace( '//', '/', $fileEnv . '/' . $fileSlug . '/' . $filePath . '/' . $fileName );

        $fileContent = $this->schema['websiteBuild']['domain']['host']['robotTxt'][0]['content']['code'];

        // Handle remove robotTxt
        if ( in_array( $fileSlug, Storage::disk('build-development')->directories() ) && Storage::disk('build-development')->has( $fileRoot . $fileName ) ) Storage::disk('build-development')->delete( $fileRoot . $fileName ); 

        if ( !$this->schema['websiteBuild']['domain']['host']['robotTxt'][0]['enabled'] ) return;

        // Handle replicate directories & file @ path
        Storage::disk('build-development')->put(
            $fileRoot . $fileName, 
            $fileContent
        );

    }

    protected function replicateHumanTxt()
    {
        // Handle no replicate of humanTxt
        if ( !array_key_exists( 'humanTxt', $this->schema['websiteBuild']['domain']['host'] ) || (
            !in_array( 'humanTxt', $this->schema['websiteBuild']['replicate'] ) && !in_array( 'websiteController', $this->schema['websiteBuild']['replicate'] )
        ) ) return;

        $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
        $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
        $filePath = strtolower( $this->schema['websiteBuild']['domain']['host']['humanTxt'][0]['path'] );
        $fileName = strtolower( $this->schema['websiteBuild']['domain']['host']['humanTxt'][0]['uid'] ) . '.txt';
        $fileRoot = str_replace( '//', '/', $fileSlug . '/' . $filePath . '/' );
        $fileGlobal = str_replace( '//', '/', $fileEnv . '/' . $fileSlug . '/' . $filePath . '/' . $fileName );

        $fileContent = $this->buildContentShortcodeFindAndReplace( $this->schema['websiteBuild']['domain']['host']['humanTxt'][0]['content']['code'] );

        // Handle remove humanTxt
        if ( in_array( $fileSlug, Storage::disk('build-development')->directories() ) && Storage::disk('build-development')->has( $fileRoot . $fileName ) ) Storage::disk('build-development')->delete( $fileRoot . $fileName ); 

        if ( !$this->schema['websiteBuild']['domain']['host']['humanTxt'][0]['enabled'] ) return;

        // Handle create directories & file @ path
        Storage::disk('build-development')->put(
            $fileRoot . $fileName, 
            $fileContent
        );
    }

    protected function replicateSecurityTxt()
    {
        // Handle no replicate of securityTxt
         if ( !array_key_exists( 'securityTxt', $this->schema['websiteBuild']['domain']['host'] ) || (
            !in_array( 'securityTxt', $this->schema['websiteBuild']['replicate'] ) && !in_array( 'websiteController', $this->schema['websiteBuild']['replicate'] )
        ) ) return;

        $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
        $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
        $filePath = strtolower( $this->schema['websiteBuild']['domain']['host']['securityTxt'][0]['path'] );
        $fileName = strtolower( $this->schema['websiteBuild']['domain']['host']['securityTxt'][0]['uid'] ) . '.txt';
        $fileRoot = str_replace( '//', '/', $fileSlug . '/' . $filePath . '/' );
        $fileGlobal = str_replace( '//', '/', $fileEnv . '/' . $fileSlug . '/' . $filePath . '/' . $fileName );

        $fileContent = $this->buildContentShortcodeFindAndReplace( $this->schema['websiteBuild']['domain']['host']['securityTxt'][0]['content']['code'] );

        // Handle remove securityTxt
        if ( in_array( $fileSlug, Storage::disk('build-development')->directories() ) && Storage::disk('build-development')->has( $fileRoot . $fileName ) ) Storage::disk('build-development')->delete( $fileRoot . $fileName );

        if ( !$this->schema['websiteBuild']['domain']['host']['securityTxt'][0]['enabled'] ) return;
        
        // Handle create directories & file @ path
        Storage::disk('build-development')->put(
            $fileRoot . $fileName, 
            $fileContent
        );
    }

    protected function replicateCode()
    {
        
        // Handle skip when no replicate for code
        if ( !in_array( 'code', $this->schema['websiteBuild']['replicate'] ) && !in_array( 'websiteController', $this->schema['websiteBuild']['replicate'] ) ) return;
        
        if ( $this->schema['websiteBuild']['blueprint'] === 'website' && isset( $this->schema['website']['code'] ) ) $fileCode = $this->schema['website']['code'];
        if ( $this->schema['websiteBuild']['blueprint'] === 'website_controller' && isset( $this->schema['websiteController']['code'] ) ) $fileCode = $this->schema['websiteController']['code'];

        if ( !isset( $fileCode ) ) return;

        foreach( $fileCode as $_fileCodeEntry )
        {
            
            $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
            $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
            $fileUid = $_fileCodeEntry['uid'];
            $fileName = $_fileCodeEntry['name'];
            $fileExt = $_fileCodeEntry['ext'];
            $filePath = $_fileCodeEntry['path'] ?? '/src' . $this->buildPageRouteTree( $this->schema['websiteBuild']['id'], $this->schema['websiteBuild']['navigation'] );
            $fileRoot = $this->buildPageRouteCleaned( $fileSlug . '/' . $filePath, $fileName, $fileExt );
            $fileGlobal = $this->buildPageRouteCleaned( $fileEnv . '/' . $fileSlug . '/' . $filePath, $fileName, $fileExt );

            // Handle deleting code
            if ( !$_fileCodeEntry['enabled'] ) 
            {
                Storage::disk( $fileEnv )->delete( $fileRoot );
                continue;
            }
            
            $fileContent = $this->buildContentShortcodeFindAndReplace( $_fileCodeEntry['content']['code'] );
            
            // Handle create directories & file @ path
            Storage::disk( $fileEnv )->put(
                $fileRoot, 
                $fileContent
            );
        }

    }

    protected function replicateAsset( $_asset )
    {
        // Handle skip when no replicate for assets
        if ( 
            // website replicate rules
            $this->schema['websiteBuild']['blueprint'] === 'website' && sizeOf( $this->schema['websiteBuild']['replicate'] ) === 0
            // websiteController replicate rules
            || $this->schema['websiteBuild']['blueprint'] === 'website_controller' && ( !in_array( $_asset, $this->schema['websiteBuild']['replicate'] ) && !in_array( 'websiteController', $this->schema['websiteBuild']['replicate'] ) ) 
        ) return;
        
        if ( $this->schema['websiteBuild']['blueprint'] === 'website' && isset( $this->schema['website'][$_asset] ) ) $file = $this->schema['website'][$_asset];
        if ( $this->schema['websiteBuild']['blueprint'] === 'website_controller' && isset( $this->schema['websiteController'][$_asset] ) ) $file = $this->schema['websiteController'][$_asset];

        if ( !isset( $file ) ) return;

        foreach( $file as $fileEntry )
        {

            $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
            $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
            $fileUid = $fileEntry['uid'];
            
            $filePath = $fileEntry['file'];
            $filePathParts = explode( '/', $fileEntry['file'] );
            $filePathName = array_pop( $filePathParts );
            $filePathOnly = implode( '/', array_slice( $filePathParts, 1 ) );
            
            $fileSource = Storage::disk('assets')->path('');
            $fileSourcePath = $fileSource . $filePath;
            
            $fileDestination = Storage::disk( $fileEnv )->path('') . $fileSlug . '/static/lib/' . $filePathOnly . '/';
            $fileDestinationPath =  $fileDestination . $filePathName;
            
            // Handle deleting existing file(s) & directorie(s). Desitnation only - never the source!
            if ( !$fileEntry['enabled'] ) 
            {

                // Handle deletion of file
                File::delete( $fileDestinationPath );

                // Handle deletion of empty parent directory ONLY!
                if ( sizeOf( File::directories( $fileDestination ) ) === 0 ) File::deleteDirectory( $fileDestination );

                continue;
            }
            
            // Handle creation of directory('s)
            if ( !File::isDirectory( $fileDestination ) ) File::makeDirectory( $fileDestination, 0777, true, true );

            // Handle creation of file
            File::copy( $fileSourcePath, $fileDestinationPath );
        }

        sleep(2);
    }

    protected function replicatePage()
    {

        // Handle replicate error - require at least page and/or children
        if ( !in_array( 'page', $this->schema['websiteBuild']['replicate'] ) && !in_array( 'children', $this->schema['websiteBuild']['replicate'] ) ) throw new \Exception( $this::ERROR_SCHEMA_REPLICATE_PAGE_MISSING );
        
        // Handle no replicate of website
        if ( $this->schema['websiteBuild']['replicate'][0] === 'null') return;

        // Handle replicate of website page
        $fileEnv = 'build-' . strtolower( $this->schema['websiteBuild']['target'] );
        $fileSlug = strtolower( $this->schema['websiteBuild']['domain']['slug'] );
        $fileUid = $this->schema['websiteBuild']['template']['uid'];
        $fileName = $this->schema['websiteBuild']['template']['name'];
        $fileExt = $this->schema['websiteBuild']['template']['ext'];
        $filePath = ( $this->schema['websiteBuild']['template']['path'] ?? '/src' ) . '/' . $this->buildPageRouteTree( $this->schema['websiteBuild']['id'], $this->schema['websiteBuild']['navigation'] );
        $fileRoot = $this->buildPageRouteCleaned( $fileSlug . '/' . $filePath, $fileName, $fileExt );
        $fileGlobal = $this->buildPageRouteCleaned(  $fileEnv . '/' . $fileSlug . '/' . $filePath, $fileName, $fileExt );

        $fileContent = $this->buildContentShortcodeFindAndReplace( $this->schema['websiteBuild']['template']['output'] );
        
        // Handle delete when not enabled.
        if ( !$this->schema['websiteBuild']['template']['enabled'] )
        {
            Storage::disk( $fileEnv )->deleteDirectory( '/' . $fileSlug . '/' . $filePath );
            return;
        }
        
        // Handle create directories & file @ path
        Storage::disk( $fileEnv )->put(
            $fileRoot, 
            $fileContent
        );

        sleep(2);

    }

    protected function replicateBuild() 
    {
        $buildEnv = Storage::disk( 'build-' . $this->schema['websiteBuild']['target'] );
        $buildEnvDirectory = sprintf( '/storage/%s', explode( 'storage/', $buildEnv->path('') )[1] );
        $buildType = $this->schema['websiteBuild']['target'];
        $buildSlug = $this->schema['websiteBuild']['domain']['slug'];
        $buildDirectoriesRoot = $buildEnv->directories( $this->schema['websiteBuild']['domain']['slug'] );
        $buildDirectoriesNode = $buildEnv->directories( $this->schema['websiteBuild']['domain']['slug'] . '/node_modules' );
        $buildDirectoryUserPath = 'cd ' . $buildEnv->path('') . $buildSlug . '&& PATH=' . getenv('PATH') . ':/usr/local/bin';

        // Handle old build remove
        if ( in_array( $buildSlug . '/.svelte-kit', $buildDirectoriesRoot ) ) $buildEnv->deleteDirectory( $buildSlug . '/.svelte-kit' );
        if ( in_array( $buildSlug . '/build', $buildDirectoriesRoot ) ) $buildEnv->deleteDirectory( $buildSlug . '/build' );
        
        // Install node_modules if not already
        if ( sizeof( $buildDirectoriesNode ) <= 0 ) 
        {
            exec( $buildDirectoryUserPath . ' npm install 2>&1');
            sleep(5);
        }

        // Handle build locally ONLY
        //exec('cd ' . $buildEnv->path('') . $buildSlug . '&& PATH=' . getenv('PATH') . ':/usr/local/bin npm run ' . $buildType . ' 2>&1');
        if ( $buildType === 'local' ) exec( $buildDirectoryUserPath . ' npm run ' . $buildType . ' 2>&1' );

        // Handle git commit
        // Change credentials to app then back to system

        // SSH Keygen command: ssh-keygen -o -t rsa -C "jamallo@castlebranch.com"
        // SSH Add command: ssh-add -K ~/.ssh/id_rsa
        // SSH passphrase command: 209734Jm
        // https://statamic.com/forum/5247-enabling-automatic-git-push-ssh-key-not-being-used
        // Get PHP Shell command permissions: https://stackoverflow.com/questions/52680408/commit-changes-on-webserver-to-github-repo-using-php-not-working
        //exec( 'git add ' . $buildEnv->path('') . ' https://jamallo:1976-Hanover-PA@github.com/cb-jamallo/2021-CB-Demo-Statamic-Preview.git 2>&1' );
        $l = exec( $buildDirectoryUserPath . ' whoami' );
        $l = exec( $buildDirectoryUserPath . ' id' );
        $l = exec( $buildDirectoryUserPath . ' git remote -v' );
        $l = exec( $buildDirectoryUserPath . ' git add -A' );
        $l = exec( $buildDirectoryUserPath . ' git commit -m "Automated Commit" 2>&1' );
        //$l = exec( $buildDirectoryUserPath . ' git push git@github.com:cb-jamallo/2021-CB-Demo-Statamic-Preview.git main 2>&1' );
        $l = shell_exec( $buildDirectoryUserPath . ' git push origin main 2>&1' );
        
        $l = exec( $buildDirectoryUserPath . ' git remote set-url statamic 2>&1' );
        $l = shell_exec( $buildDirectoryUserPath . ' git push git@github.com:cb-jamallo/2021-CB-Demo-Statamic-Preview.git main 2>&1' );
        
        // $m = "Returned with status $return_var and output:\n";
        // $m = print_r($output, false );
        // SSH Teesting Command: ssh -T git@github.com
        // $githubClass = new GithubClass( $this->schema, $buildEnv->path('') . $buildSlug );
        // $githubClass->repoExec( $buildDirectoryUserPath . ' git add -A' );
        // $githubClass->repoExec( $buildDirectoryUserPath . ' git commit -m "Automated Commit"' );
        // $githubClass->repoExec( $buildDirectoryUserPath . ' git remote set-url statamic' );
        // $githubClass->repoExec( $buildDirectoryUserPath . ' git push git@github.com:cb-jamallo/2021-CB-Demo-Statamic-Preview.git main' );
    }   

    // Find and Replace string content for schema path shortcodes
    protected function buildContentShortcodeFindAndReplace( $_string )
    {

        $regexShortcode = $this->shortcodeClass->all( $_string );

        $regexContent = $_string;
        
        // Handle no shortcodes
        if ( !$regexShortcode ) return $regexContent;

        forEach( $regexShortcode[0] as $regexShortcodeEntry )
        {
            if ( empty( $regexShortcodeEntry ) ) continue;
            
            $regexContent = str_replace( 
                '[' . $regexShortcodeEntry . ']',          // 1. Shortcode string
                $this->shortcodeClass->findAndReplace([    // 2. Shortcode replacement
                    'path' => $regexShortcodeEntry,
                    'array' => $this->schema
                ]),
                $regexContent                              // 3. Shortcode content origin
            );

        };

        return $regexContent;
    }


     /*

    <!-- Build Comment:
    MODIEFER RULES: Data (*) Return data object instead of String
    ...::data_php_array // PHP Array
    ...::data_js_array // PHP/JS
    ...::data_js_json // JS
    ...::tag // string
    ...::attribute // array
    ...::modifier // array
    ...::outer // string default
    ...::inner // string
    ...::children // array

    MODIFIER RULES: FIND/REPLACE
    [website.template.page :find=class='wrapper :replace=class='wrapper even]

    MODIEFER RULES: ATTR (*) String(s)
    :attribute_only=test1,...
    :attribute_except=test1,...
    :attribute_before=test~test2,...
    :attribute_after=test~test2,...

    MODIEFER RULES: ITEM (metadata, asset, misc???) String(s)
    :item_only=test1,...
    :item_except=test1,...
    :item_merge_before=test1~test2,... // TBD...
    :item_sort= // TBD...
    :item_sort_before=test~test2
    :item_sort_after=test~test2

    MODIEFER RULES: OUTER/INNER (metadata, asset, template, misc) String(s)
    :outer/inner
    :outer/inner_query // Nested Tag Query TBD...
    :outer/inner_replace=name~value,... // TBD
    :inner/inner_replace_all=name~value,... // TBD

    SHORTCODE GET EXAMPLE:
    ex: returns <tag> string w/ modfidied attributes
    [website_controller.template.page :attribute_only]

    ex: returns attribute string w/ modfidied attributes
    [website_controller.template.page::inner :attribute_only=...]

    
    [website_controller.template.*.tag] // Returns: String Tag Attr's Only
    [website_controller.template.*.attribute] // Returns: String Tag Attr's Only
    [website_controller.template.*.modifier] // Returns: String Tag Mod's Only
    [website_controller.template.*.outer] // Returns: String Default Outer Only
    [website_controller.template.*.?inner] // DEFUALT Returns: String Tag Inner Only

    [websiteController.template.build_html.body]
        [website.meta.title] 
        [website.template.build_html.body]
    [/websiteController.template.build_html.body]

    #1 Run Group Find/Replace
        - Run Attr & List Find Replace
    #2 Run Sinlge Find/Replace
        - Run Attr & List Find Replace


    // Ex:
        - [websiteController.template.build_html.body]
        - [websiteController.template.build_html.body_attr]
        - [websiteController.template.build_html.body_content]

    // Ex: merged
        - [websiteBuild.template.build_html.body]
        - [websiteBuild.template.build_html.body_attr]
        - [websiteBuild.template.build_html.body_content]

    // Ex: Except
        - [websiteBuild.template.build_html.body_attr -attr_except=title1]
        - [websiteBuild.metadata.link -except=title1]

    // Ex: Only
        - [websiteBuild.template.build_html.body_attr -attr_only=title1]
        - [websiteBuild.metadata.link -except=title1]
    -->
     */

}