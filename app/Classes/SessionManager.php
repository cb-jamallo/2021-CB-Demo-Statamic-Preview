<?php 
    
namespace App\Classes;

// Custom Classes
use Statamic\Facades\User;
use App\Classes\ToastClass;


class SessionManager
{

    private const ERROR_SESSION = 'Failed to initialize SessionManager for the WebsiteNavigation %s';

    private $event = null;
    private $eventType = null;
    private $toastManager = null;

    public function __construct( $_ARGS = null )
    {
        // Do something...
    }

    static public function get( $_ARGS )
    {
        if ( !isset( $_ARGS['key'] ) ) return null; // REQUIRED...
        
        return $_SESSION[ $_ARGS['key'] ];
    }

    static public function set( $_ARGS )
    {

        if ( !isset( $_ARGS['key'] ) && gettype( $_ARGS ) === 'array') self::setMany( $_ARGS );

        if ( !isset( $_ARGS['key'] ) ) return false; // REQUIRED...
        if ( !isset( $_ARGS['value'] ) && !isset( $_ARGS['nullable'] ) ) return false; // REQUIRED...

        $_SESSION[ $_ARGS['key'] ] = $_ARGS['value'];

        return $_ARGS;
    }

    static protected function setMany( $_ARGS )
    {
        foreach( $_ARGS as &$item )
        {
            if ( self::keyExists( array( 'key' => $item['key'] ) ) )
            {
                $_SESSION[ $item['key'] ] = $item['value'];
            }
        }

        return $_ARGS;
    }

    static public function keyExists( $_ARGS )
    {

        if ( !isset( $_SESSION[ $_ARGS['key'] ] ) ) return false; // REQUIRED...

        return true;
    }


}