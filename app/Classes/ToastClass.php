<?php 
    
namespace App\Classes;

// Statamic Classes
use Statamic\Facades\CP\Toast;

// Custom Classes
use App\Classes\SessionManager;


class ToastClass
{

    public $toastMessage = ''; 
    public $toastDuration = null;
    public $toastMessageInfo = array();
    public $toastMessageSuccess = array();
    public $toastMessageError = array();

    public function __construct( $_ARGS )
    {
        // DO something...
        
    }

    public static function reset()
    {
        SessionManager::set(array(
            'key' => 'toast',
            'value' => array(
                'logs' => array(),
                'counts' => array(
                    'error' => 0,
                    'info' => 0,
                    'success' => 0
                )
            )
        ));
    }

    public static function log( $_ARGS )
    {
        if ( !SessionManager::get( array( 'key' => 'toast' ) ) ) self::reset();
        return self::parse( $_ARGS );
    }

    public static function get()
    {
        return SessionManager::get( array( 'key' => 'toast' ) );
    }

    protected static function parse( $_ARGS )
    {
        $toast = SessionManager::get( array( 'key' => 'toast' ) );

        switch( $_ARGS['toastType'] )
        {
            case 'info':
                $toast['counts']['info'] += 1;
                break;
            case 'error':
                $toast['counts']['error'] += 1;
                break;
            default:
                $toast['counts']['success'] += 1;
                break;
        }
        
        array_push(
            $toast['logs'],
            $_ARGS
        );

        SessionManager::set(array(
            'key' => 'toast',
            'value' => $toast
        ));
    }

    public static function report( $_ARGS )
    {

        $toast = self::get();
        
        if ( count( $toast['logs'] ) > 0)
        {
            foreach( $toast['logs'] as &$log )
            {

                $duration = ( isset( $log['toastDuration'] ) ) 
                            ? $log['toastDuration']
                            : 2000;

                switch( $log['toastType'] )
                {
                    case 'info':
                        Toast::info( $log['toastMessage'] )->duration( $duration );
                        break;
                    case 'error':
                        Toast::error( $log['toastMessage'] )->duration( $duration );
                        break;
                    default:
                        Toast::success( $log['toastMessage'] )->duration( $duration );
                }
            }
        }

        // Final Success toast - if no errors reported...
        if ( $toast['counts']['error'] !== 0 ) return;
        
        Toast::success( $_ARGS['toastMessage'] )->duration( $_ARGS['toastDuration'] );


    }

}