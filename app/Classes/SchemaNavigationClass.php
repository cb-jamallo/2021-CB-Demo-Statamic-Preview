<?php 
    
namespace App\Classes;

// Statamic Classes
use Statamic\Facades\Stache;
use Statamic\Facades\Entry;
use Statamic\Facades\Collection;
use Symfony\Component\Yaml\Yaml;

// Custom Classes
use App\Classes\ToastClass as ToastClass;

class SchemaNavigationClass
{

    private const ERROR_SCHEMA_WEBSITE_NAVIGATION_INIT = 'Failed to initialize for the WebsiteNavigation %s';

    public $schema = null;

    public function __construct( $_ARGS = null )
    {
    
    }


    public function init( $_ARGS = null )
    {

        try
        {
            $this->schema = $_ARGS['schema'];
            
            $this->schema['website']['navigation'] = array(
                'file' => null,
                'root' => null,
                'yaml' => null,
                'tree' => null,
            );

            $this->parseSite( array( 'handle' => $this->schema['website']['blueprint'], 'site' => 'default' ) );
            $this->parseRoot();
            $this->parseTreeYaml();
            $this->parseTreeArray();
            
        }
        catch(\Exception $_error)
        {
            ToastClass::log(array(
                'toastType' => 'error',
                'toastMessage' => sprintf( 
                    $this::ERROR_SCHEMA_WEBSITE_NAVIGATION_INIT,
                    $this->schema['website']['slug'],
                ),
                'toastDuration' => 4000
            ));
        }

        return $this->schema;

    }

    /*
    */
    protected function parseSite ( $_ARGS )
    {
        $stache = Stache::sites('default');
        $this->schema['website']['navigation']['file'] = $stache->stores()['collection-trees']->paths()[ $_ARGS['handle'] . '::' . $_ARGS['site'] ];
    }

    protected function parseRoot ()
    {
        $this->schema['website']['navigation']['root'] = $this->schema['website']['root']->id();   
    }

    protected function parseTreeYaml ()
    {
        $this->schema['website']['navigation']['yaml'] = file_get_contents( $this->schema['website']['navigation']['file'] );
    }

    protected function parseTreeArray ( $_ARGS = null )
    {
        
        $root = isset( $_ARGS['root'] ) 
                ? $_ARGS['root']
                : null;

        $tree =  isset( $_ARGS['tree'] )
                    ? $_ARGS['tree']
                    : Yaml::parse( $this->schema['website']['navigation']['yaml'] )['tree'];
        
        if ( !$root )
        {
            foreach( $tree as &$key )
            {
                if ( $key['entry'] === $this->schema['website']['navigation']['root'])
                {
                    $root = $key;
                    break;
                }
            }

        }

        $entry = Entry::find( $root['entry'] );
        
        $entryId = $entry->id();

        $entrySlug = ( !isset( $_ARGS['root'] ) )
                    ? ''
                    : $entry->slug();

        $entryTitle = ( !isset( $_ARGS['root'] ) )
                    ? ( $entry->data()->get('title_alias') )
                        ? $entry->data()->get('title_alias')
                        : $entry->data()->get('title_alias') // Force title alias for home...
                    : $entry->data()->get('title');

        $entryBreadcrumb = ( !isset( $_ARGS['root'] ) )
                    ? array()
                    : $_ARGS['breadcrumb'];

        $entryUri = ( !isset( $_ARGS['root'] ) )
                    ? ''
                    //: str_replace( '//', '/', '/' . $_ARGS['uri'] . '/' )  . $entry->slug();
                    : str_replace( '//', '/', '/' . $_ARGS['parent']['uri'] . '/' )  . $entry->slug();
        
        $entryEnabled = $entry->data()->get('development-template')[0]['enabled'];

        $entry = array(
            'id' => $entryId,
            'title' => $entryTitle,
            'slug' => $entrySlug,
            'uri' => $entryUri,
            'enabled' => json_encode( $entryEnabled ),
        );

        if ( isset( $_ARGS['breadcrumb'] ) )
        {
            array_push(
                $entryBreadcrumb,
                array(
                    'id' => $_ARGS['parent']['id'],
                    'title' => $_ARGS['parent']['title'],
                    'slug' => $_ARGS['parent']['slug'],
                    'uri' => $_ARGS['parent']['uri']
                )
            );

            $entry['breadcrumb'] = $entryBreadcrumb;
        }

        if ( isset( $root['children'] ) )
        {

            $entry['children'] = array();

            foreach( $root['children'] as &$child)
            {
                array_push(
                    $entry['children'],
                    $this->parseTreeArray(array(
                        'tree' => $tree,
                        'root' => $child,
                        'parent' => $entry,
                        'breadcrumb' => $entryBreadcrumb,
                        'uri' => $entrySlug
                    ))
                );
            }

        }

        if ( isset( $_ARGS['parent'] ) )
        {
            return $entry;
        }

        $this->schema['website']['navigation']['tree'] = $entry;
        
    }


}