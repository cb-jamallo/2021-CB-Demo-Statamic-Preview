<?php 
    
namespace App\Classes;

// Statamic Classes
use Statamic\Facades\CP\Toast;

// Custom Classes
use App\Classes\SessionManager;
use App\Classes\ToastClass;


class ShortcodeClass
{

    /**
    * Constants 
    */
    private const ERROR_SHORTCODE_VALID_MISSING = 'ShortcodeManager $_ARGS required argument \'regexShortcode\' is missing.';
    private const ERROR_SHORTCODE_VALID_NOT_ARRAY = 'ShortcodeManager $_ARGS required argument \'regexShortcode\' is not in the correct array format.';
    private const ERROR_SHORTCODE_VALID_CONTENT_MISSING = 'ShortcodeManager $_ARGS required argument \'regexContent\' is missing.';
    private const ERROR_SHORTCODE_VALID_CONTENT_NOT_STRING = 'ShortcodeManager $_ARGS required argument \'regexContent\' is not in the correct string format.';

    private const ERROR_SHORTCODE_PARSE_COMPILE_TWO_WAY_DISALLOWED = 'ShortcodeManager detected a forbidden two-way compile attempt for %s & %s';



    /**
    * Variables 
    */
    
    public $shortcodePlaceholder = 'shortcode';
    public $shortcodePatternTag = '/\[[^\:|\s|\/]{1,}\s?[^\]]{1,}\]/UX';
    public $shortcodePatternAttribute = '/(\s?[^\=]{1,}\=\'[^\']{1,}\'){1,}/UX';
    public $shortcodePatternAttributeKeyModifier = '/([^\:]*\:)?([^\:]*)(\:[^\:]*)?/';
    public $shortcodePatternGroup = '#\[\[(shortcode)\:?([^\s|\]]*)?\s?([^\]]*)\](?:((?:[^\[]|\[(?!\/?shortcode\s?[^\]]*)|(?R))+)\[\/shortcode[^\]]*\]\])?#';

    /**
    * @method array get()
    * @method array parseAttribute()
    * @method array recursive()
    * @method string parseType()
    * @method string parseMinify()
    * @method string parseTrimShortcode()
    * @method bool validShortcode()
    * @method bool validContent()
    */

    public function __construct( $_ARGS = null )
    {
        // DO something...
        
    }

    /**
    * Find and parse shortcodes
    *
    * Recieves a string value and returns a deep nested assoc. array of all proper formatted shortcodes.
    *
    * @since 1.0.0.
    *
    **/
    public function all( $_STRING )
    {
        preg_match_all(
            $this->shortcodePatternTag,
            $_STRING,
            $regexMatch,
        );

        // Handle remove '[' & ']' chars
        array_walk( $regexMatch[0] , function( &$regexMatchEntry, $regexMatchIndex ) use ( $regexMatch )
        {
            return $regexMatchEntry = str_replace('[',  '', str_replace( ']', '', $regexMatchEntry ) );
        });

        // $regexMatch = $this->get([
        //     'regexShortcode' => $regexMatch[0],
        //     'regexContent' => $_STRING
        // ]);

        return $regexMatch;
    }

    /**
    * Find and parse shortcode group data
    *
    * Recieves an assoc. array of groups to find in a content string and recursively returns the results.
    *
    * @since 1.0.0.
    *
    * @see {sting} $this->shortcodePlaceholder
    * @see {regex} $this->shortcodePatternGroup
    * @see {function} $this->validContent
    * @see {function} $this->validShortcode
    * @see {function} $this->parseAttribute
    * @see {function} $this->parseType
    * @see {function} $this->parseMinify
    *
    * @param {array} $_ARGS
    * {
    *       @type {array} 'regexShortcode' an array of named groups to search for in the content. 
    *       @type {string} 'regexContent' is the string of content to be searched for groups.
    * }
    *
    * @return {array} Return assoc. array of the results.
    *
    */
    public function get( $_ARGS )
    {

        $this->validContent( $_ARGS );
        $this->validShortcode( $_ARGS );

        $regexMatch = null;
        $regexShortcode = $_ARGS['regexShortcode'];
        $regexShortcodeHandled = $_ARGS['$regexShortcodeHandled'] ?? [];
        $regexContent = $this->parseTrimShortcode( 
            $this->parseMinify( $_ARGS['regexContent'] ) 
        );
        $regexResult = $_ARGS['regexResult'] ?? [];

        foreach ( $regexShortcode as $regexShortcodeEntry )
        {
            // Set pattern
            $regexPattern = str_replace( $this->shortcodePlaceholder, $regexShortcodeEntry, $this->shortcodePatternGroup );

            // Get pattern matches
            preg_match_all( 
                $regexPattern,
                $regexContent,
                $regexMatch
            );

            // Traverse pattern results
            if ( count( $regexMatch ) > 0)
            {
                
                // Handle already marked by ignoring
                if ( in_array( $regexShortcodeEntry, $regexShortcodeHandled ) ) continue;

                // Mark as handled to ignore later
                array_push( $regexShortcodeHandled, $regexShortcodeEntry );

                foreach ( $regexMatch[0] as $regexMatchKey => $regexMatchValue )
                {
                    if ( $regexMatch[0][ $regexMatchKey ] ?? null ) 
                    {

                        // Handle capture
                        array_push(
                            $regexResult,
                            [
                                'shortcode' => $regexMatch[1][ $regexMatchKey ],
                                // 'group' => !empty( $regexMatch[5][ $regexMatchKey ] ),
                                'type' => $this->parseType( [ 'regexContent' => trim( $regexMatch[2][ $regexMatchKey ?? '' ] ) ] ),
                                'attribute' => $this->parseAttribute( [ 'regexContent' => trim( $regexMatch[3][ $regexMatchKey ] ?? '' ) ] ),
                                'outer' => $regexMatch[0][ $regexMatchKey ],
                                'inner' => $regexMatch[ count( $regexMatch ) - 1 ][ $regexMatchKey ],
                            ]
                        );
                        
                        // Handle content
                        $regexResultContent = $regexMatch[ count( $regexMatch ) - 1 ][ $regexMatchKey ];

                        // Handle children capture
                        $regexResultContentChildren = array_filter( $regexShortcode, function( $regexShortcodeEntryChild ) use ( $regexResultContent, $regexShortcodeHandled ) 
                        {
                            if ( str_contains( $regexResultContent, '[' . $regexShortcodeEntryChild ) //);
                                 && str_contains( $regexResultContent, '[/' . $regexShortcodeEntryChild ) )
                            {
                                if ( !in_array( $regexShortcodeEntryChild, $regexShortcodeHandled ) ) return $regexShortcodeEntryChild;
                            }
                        });

                        // Handle children capture
                        if ( count( $regexResultContentChildren ) > 0 )
                        {

                            $regexResult[ count( $regexResult ) - 1 ]['children'] = [];

                            foreach ( $regexResultContentChildren as $regexResultContentChildrenEntry )
                            {
                                // Handle already marked by ignoring
                                array_push( $regexShortcodeHandled, $regexResultContentChildrenEntry );

                                // Handle child deep nesting
                                array_push( 
                                    $regexResult[ count( $regexResult ) - 1 ]['children'],
                                    $this->get([
                                        'regexShortcode' => array( $regexResultContentChildrenEntry ),
                                        'regexShortcodeHandled' => $regexShortcodeHandled,
                                        'regexContent' => $regexResultContent,
                                        'regexResult' => $regexResult[ count( $regexResult ) - 1 ]['children']
                                    ])
                                );


                            }
                        }

                    }
                }
            }
        }

        return $regexResult;
    }


    // Find path value in multidimensional array
    // $_ARGS['path'] string dot notated path
    // $_ARGS['array'] multidimensional array
    public function findAndReplace( $_ARGS )
    {
        $array = $_ARGS['array'];
        $array_original = $_ARGS['array_original'] ?? $_ARGS['array'];
        
        $path = explode( '.', str_replace( '[', '', str_replace( ']', '', $_ARGS['path'] ) ) );
        $path_original = $_ARGS['path_original'] ?? $_ARGS['path'];
        $path_target = array_shift( $path );
        
        $content = $_ARGS['content'];
        
        if ( count( $path ) === 0 )
        {

            // Target array w/ existing path target
            if ( is_array( $array ) && isset( $array[ $path_target ] ) ) return $array[ $path_target ];

            // Target $array reduced to string value
            if ( !is_array( $array ) && !empty( $array ) ) return $array;

            // We got nothin to change...return content.
            return $content;
        }

        if ( isset( $array[ $path_target ] ) && is_array( $array[ $path_target ] ) )
        {

            sleep(1);
            return $this->findAndReplace([ 
                'array' => $array[ $path_target ],
                'array_original' => $array_original,
                'path' => implode( '.', $path ),
                'path_original' => $path_original,
                'content' => $content
            ]);
        }

        return ( $array[ $path_target ] ) ? $array[ $path_target ] : $content;
    }


    public function parseCompile( $_ARGS )
    {
        $a = $_ARGS['a'];
        $aShortcode = $this->parseTrimShortcode( $a['shortcode'] );
        $aContent = $this->parseMinify( $this->parseTrimShortcode( $a['content'] ) );
        
        $b = $_ARGS['b'];
        $bShortcode = $this->parseTrimShortcode( $b['shortcode'] );
        $bContent = $this->parseMinify( $this->parseTrimShortcode( $b['content'] ) );

        $compile = '';
        $compileA = str_contains( $aContent, $bShortcode );
        $compileB = str_contains( $bContent, $aShortcode );

        // Void two-way compile attempt.
        if ( $compileA && $compileB ) throw new \Exception( sprintf( 
            $this::ERROR_SHORTCODE_PARSE_COMPILE_TWO_WAY_DISALLOWED,
            $aShortcode,
            $bShortcode
        ));

        if ( $compileA ) return $compile = str_replace( $bShortcode, $bContent, $aContent );

        if ( $compileB ) return $compile = str_replace( $aShortcode, $aContent, $bContent );

        if ( !empty( $aContent ) ) return $aContent;

        if ( !empty( $bContent ) ) return $bContent;

        return '';

    }

    /**
    * A list of attributes.
    *
    * Receives content and returns and assoc. array of [key => '...', value => '...'] pairs.
    *
    * @since 1.0.0
    * @param @{string|array} $_MIXED
    *
    * @return {array} list of [ [key => '...', value => '...'], ... ] pairs.
    */
    private function parseAttribute( $_MIXED )
    {
        $regexAttribute = [];

        $regexContent = '';

        if ( is_array( $_MIXED ) && array_key_exists( 'regexContent', $_MIXED ) ) $regexContent = $_MIXED['regexContent'];
        if ( is_string( $_MIXED ) ) $regexContent = $_MIXED;

        preg_match_all(
            $this->shortcodePatternAttribute,
            $regexContent,
            $regexMatchAttribute,
        );

        if ( $regexMatchAttribute[0] ) 
        {
            foreach( array_shift( $regexMatchAttribute ) as &$regexMatchAttributePair )
            {
                $regexAttributePair = explode( '=', preg_replace( '/\s|\'/U', '', $regexMatchAttributePair ) );
                preg_match( $this->shortcodePatternAttributeKeyModifier, $regexAttributePair[0], $regexAttributePairKey );

                array_push(
                    $regexAttribute,
                    [
                        'premodifier' => trim( str_replace( ':', '', $regexAttributePairKey[1] ?? '' ) ),
                        'key' => trim( $regexAttributePairKey[2] ?? '' ),
                        'postmodifier' => trim( str_replace( ':', '', $regexAttributePairKey[3] ?? '' ) ),
                        'value' => trim( $regexAttributePair[1] )
                    ]
                );
            }
        }
        
        return $regexAttribute;
    }

    /**
    * A list of types.
    *
    * Receives content and returns and assoc. array of [type, type, ...] types.
    *
    * @since 1.0.0
    * @param @{string|array} $_MIXED
    * 
    * @return {array} list of [type, type, ...] types.
    */
    private function parseType( $_MIXED )
    {
        $regexContent = null;

        if ( is_array( $_MIXED ) && array_key_exists( 'regexContent', $_MIXED ) ) $regexContent = $_MIXED['regexContent'];
        if ( is_string( $_MIXED ) ) $regexContent = $_MIXED;

        // Split w/o err if char separator doesn't exist.
        $regexContent = ( stristr( $regexContent, ':' ) ) ? preg_split("/\:/", $regexContent ) : [];

        return $regexContent;
    }

    /**
    * Minify a string.
    *
    * Receives string content and returns updated string that is free from all human-readable carriage returns, tabs, excess spaces, and newline breaks.
    *
    * @since 1.0.0
    *
    * @param @{string} $_STRING
    *
    * @return {string} Return a string result.
    */
    public function parseMinify( $_STRING )
    {
        return trim( 
            preg_replace('/\r|\n|\f|\t|\s{2,}+/xm', '', $_STRING ) // Minify...
        );
    }

    /**
    * Clean shortcode tags.
    *
    * Receives string content and returns updated string that is free from all excess spaces not acceptable in a [Shortcode] tag.
    *
    * @since 1.0.0
    *
    * @param @{string} $_STRING
    *
    * @return {string} Return a string result.
    */
    public function parseTrimShortcode( $_STRING )
    {
        return trim( 
                preg_replace('/\[\/\s/UXm', '[/', // Cleans Shortcode open start bracket
                    preg_replace('/\s\]/UXm', ']', // Cleans Shortcode open/close end bracket
                        preg_replace('/\[\s/UXm', '[', strtolower( $_STRING ) ) // Cleans Shortcode close bracket
                )
            )
        );
    }

    /**
    * Valid assoc. array key/value pairs.
    *
    * Recieves an assoc. array and checks that it contains the appropriate key / value pairs required for associate methods.
    *
    * @see {array} $shortcodes.
    * @since 1.0.0.
    * @param @{array} $_ARGS {
    *       @type {array} 'regexShortcodes' is a list (enum) of key strings.
    * }
    * @return {bool} Return bool if param contains correct pairs.
    */
    public function validShortcode( $_ARGS )
    {
        if ( !isset( $_ARGS['regexShortcode'] ) ) throw new \Exception( ERROR_SHORTCODE_VALID_MISSING );
        if ( gettype( $_ARGS['regexShortcode'] ) !== 'array' ) throw new \Exception( ERROR_SHORTCODE_VALID_NOT_ARRAY );
    }

    /**
    * Valid assoc. array key/value pairs.
    *
    * Recieves an assoc. array and checks that it contains the appropriate key / value pairs required for associate methods.
    *
    * @see {array} $shortcodes.
    * @since 1.0.0.
    * @param @{array} $_ARGS {
    *       @type {string} 'regexContent' strong of html and/or plain text content.
    * }
    * @return {bool} Return bool if param contains correct pairs.
    */
    public function validContent( $_ARGS )
    {
        if ( !isset( $_ARGS['regexContent'] ) ) throw new \Exception( ERROR_SHORTCODE_VALID_CONTENT_MISSING );
        if ( gettype( $_ARGS['regexContent'] ) !== 'string' ) throw new \Exception( ERROR_SHORTCODE_VALID_CONTENT_NOT_STRING );
    }
}
