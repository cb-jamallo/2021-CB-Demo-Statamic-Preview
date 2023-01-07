<?php 
    
namespace App\Classes;

// Statamic Classes
use Statamic\Facades\CP\Toast;

// Custom Classes
use App\Classes\SessionManager;
use App\Classes\ToastClass;


class TagClass
{   

    /**
    * Constants 
    */

    private const ERROR_TAG_VALID_MISSING = 'TagManager $_ARGS required argument \'regexShortcode\' is missing.';
    private const ERROR_TAG_VALID_NOT_ARRAY = 'TagManager $_ARGS required argument \'regexShortcode\' is not in the correct array format.';
    private const ERROR_TAG_VALID_CONTENT_MISSING = 'TagManager $_ARGS required argument \'regexContent\' is missing.';
    private const ERROR_TAG_VALID_CONTENT_NOT_STRING = 'TagManager $_ARGS required argument \'regexContent\' is not in the correct string format.';
    private const ERROR_TAG_VALID_COMPILE_MISSING = 'TagManager compile \'a\' and \'b\' missing.';
    private const ERROR_TAG_VALID_COMPILE_FORBIDDEN = 'TagManager compile \'a\' and \'b\' cross-reference forbidden.';

    /**
    * Variables 
    */

    public $tagPlaceholder = 'tag';
    public $tagPatternAttribute = '/[^\s]{1,}/'; // [^\=]{1,}\=\'[^\']*\'
    public $tagPatternAttributeKeyModifier = '/([^\:]*\:)?([^\:]*)(\:[^\:]*)?/';
    public $tagPatternGroup = '#\<(\!?tag)\s?([^\>]*)\>(?:((?:[^\<]|\<(?!\/?tag\s?[^\>]*)|(?R))+)?\<\/tag[^\>]*\>)?#';

    public $commentPatternGroup = '/\<\!\-{2,}.*\-{2,}\>/iUX';

    /**
    * Methods 
    */

    public function __construct( $_ARGS = null )
    {
        // DO something...    
    }

    public function get( $_ARGS )
    {

        $this->validContent( $_ARGS );
        $this->validTag( $_ARGS );

        $regexMatch = null;
        $regexTag = $_ARGS['regexTag'];
        $regexContent = $this->parseCommentRemove(
            $this->parseTrimTag( 
                $this->parseMinify( $_ARGS['regexContent'] ) 
            )
        );

        $regexResult = $_ARGS['regexResult'] ?? [];

        if ( $regexContent === '' ) $regexResult;

        foreach ( $regexTag as $regexTagItem )
        {

            // Set pattern
            $regexPattern = str_replace( $this->tagPlaceholder, explode( ':', $regexTagItem )[0], $this->tagPatternGroup );

            // Get pattern matches
            preg_match_all( 
                $regexPattern,
                $regexContent,
                $regexMatch
            );

            // Traverse pattern results
            if ( count( $regexMatch[0] ) > 0 )
            {
                foreach ( $regexMatch[0] as $regexMatchKey => $regexMatchValue )
                {
                    if ( $regexMatch[0][ $regexMatchKey ] ?? null ) 
                    {
                        array_push(
                            $regexResult,
                            [
                                'tag' => $regexMatch[1][ $regexMatchKey ],
                                'type' => $this->validTagType( $regexMatch[1][ $regexMatchKey ] ),
                                'attribute' => $this->parseAttribute( trim( $regexMatch[2][ $regexMatchKey ] ) ),
                                'modifier' => $this->parseAttribute( trim( $regexMatch[2][ $regexMatchKey ] ), true ),
                                'outer' => $regexMatch[0][ $regexMatchKey ],
                                'inner' => $regexMatch[3][ $regexMatchKey ],
                            ]
                        );
                        
                        $regexContent = $regexResult[ count( $regexResult ) - 1 ][ 'inner' ];

                        if ( 
                            count( array_filter( $regexTag, function( $regexTagItem ) use ( $regexContent ) {
                                return ( str_contains( $regexContent, '<' . $regexTagItem ) && str_contains( $regexContent, '>' . $regexTagItem ) );
                            } ) ) > 0 
                        )
                        {
                            $regexResult[ count( $regexResult ) - 1 ]['children'] = $this->get([
                                'regexTag' => [ $regexResult[ count( $regexResult ) - 1 ][ 'tag' ] ],
                                'regexContent' => $regexResult[ count( $regexResult ) - 1 ][ 'inner' ],
                                'regexResult' => $regexResult[ count( $regexResult ) - 1 ]
                            ]);
                        }
                    }
                }
            }
            else 
            {
                array_push( $regexResult, [ 
                    'tag' => $regexTagItem,
                    'type' => $this->validTagType( $regexTagItem ),
                    'attribute' => [],
                    'modifier' => [],
                    'outer' => '',
                    'inner' => $regexContent,
                ]);
            }
        }

        return $regexResult;
    }

    public function parseCompile( $_ARGS )
    {
        // if ( !isset( $_ARGS[ 'a' ] ) && !isset( $_ARGS[ 'b' ] ) ) throw new \Exception( $this::ERROR_TAG_VALID_COMPILE_MISSING );
        // if ( !isset( $_ARGS[ 'a' ]['tag'] ) && !isset( $_ARGS[ 'b' ]['tag'] ) ) throw new \Exception( $this::ERROR_TAG_VALID_COMPILE_MISSING );
        // if ( !isset( $_ARGS[ 'a' ]['outer'] ) && !isset( $_ARGS[ 'b' ]['outer'] ) ) throw new \Exception( $this::ERROR_TAG_VALID_COMPILE_MISSING );
        // if ( !isset( $_ARGS[ 'a' ]['inner'] ) && !isset( $_ARGS[ 'b' ]['inner'] ) ) throw new \Exception( $this::ERROR_TAG_VALID_COMPILE_MISSING );
        // if ( $_ARGS[ 'a' ]['outer'] === '' && $_ARGS[ 'b' ]['outer'] === '' ) throw new \Exception( $this::ERROR_TAG_VALID_COMPILE_FORBIDDEN );

        $result = null;

        // A consume B
        if ( $_ARGS[ 'a' ]['outer'] !== '' )
        {
            $result = [
                'a' => $_ARGS[ 'a' ],
                'b' => $_ARGS[ 'b' ],
                'schema' => 'website'
            ];
        }
        // B consume A
        else
        {
            $result = [
                'a' => $_ARGS[ 'b' ],
                'b' => $_ARGS[ 'a' ],
                'schema' => 'websitecontroller'
            ];
        }

        return $result;
    }

    private function parseAttribute( $_STRING, $_MODIFIER = false)
    {

        $regexAttribute = [];

        if ( empty( $_STRING ) === 0 ) return $regexAttribute;
        
        preg_match_all(
            $this->tagPatternAttribute,
            $_STRING,
            $regexMatchAttribute,
        );

        if ( $regexMatchAttribute[0] ) 
        {
            foreach( array_shift( $regexMatchAttribute ) as &$regexMatchAttributePair )
            {
                $regexAttributeSeparator = ( str_contains( $regexMatchAttributePair, '=' ) ) ? '=' : '';

                $regexAttributePair = explode( '=', preg_replace( '/\s|\'/U', '', $regexMatchAttributePair ) );
                preg_match( $this->tagPatternAttributeKeyModifier, $regexAttributePair[0], $regexAttributePairKey );

                array_push(
                    $regexAttribute,
                    [
                        'key' => trim( $regexAttributePairKey[2] ?? '' ),
                        'value' => trim( $regexAttributePair[1] ?? '' ),
                        'separator' => $regexAttributeSeparator,
                        'premodifier' => trim( str_replace( ':', '', $regexAttributePairKey[1] ?? '' ) ),
                        'postmodifier' => trim( str_replace( ':', '', $regexAttributePairKey[3] ?? '' ) ),
                    ]
                );
            }
        }
        
        return $regexAttribute;
    }

    private function parseAttributeRemoveModifier( $_ARRAY )
    {
        $remove = array_filter( array_merge( array(), $_ARRAY ), function( $item, $index )
        {
            if ( strtolower( $item[ 'premodifier'] ) === 'remove' ) return $item;
        }, ARRAY_FILTER_USE_BOTH);
        
        $original = array_filter( array_merge( array(), $_ARRAY ) , function( $item, $index ) use ( $remove )
        {
            foreach( $remove as $key => $value )
            {
                if ( $item[ 'key' ] !== $value[ 'key' ] ) return $item;
            }

        }, ARRAY_FILTER_USE_BOTH);

        return $original;
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
            preg_replace('/\s{2,}+/xm', ' ', preg_replace('/\r|\n|\f|\t+/xm', '', $_STRING ) ) // Minify...
        );
    }

    /**
    * Clean tag tags.
    *
    * Receives string content and returns updated string that is free from all excess spaces not acceptable in a [Tag] tag.
    *
    * @since 1.0.0
    *
    * @param @{string} $_STRING
    *
    * @return {string} Return a string result.
    */
    public function parseTrimTag( $_STRING )
    {
        return trim( 
                preg_replace('/\<\/\s/UXm', '</', // Cleans Tag open start bracket
                    preg_replace('/\s\>/UXm', '>', // Cleans Tag open/close end bracket
                        // preg_replace('/\<\s/UXm', '<', strtolower( $_STRING ) ) // Cleans Tag close bracket
                        preg_replace('/\<\s/UXm', '<', $_STRING ) // Cleans Tag close bracket
                )
            )
        );
    }

    public function parseCommentRemove( $_STRING )
    {
        // Get pattern matches
        preg_match_all( 
            $this->commentPatternGroup,
            $_STRING,
            $regexMatch
        );

        // Traverse pattern results
        if ( count( $regexMatch ) > 0)
        {
            foreach ( $regexMatch[0] as $regexMatchKey => $regexMatchValue )
            {
                $_STRING = str_replace( $regexMatchValue, '', $_STRING );
            }
        }

        return $_STRING;
    }

    public function parseConcatTag( $_ARGS )
    {   
        $tag = sprintf( '<%s%s>', $_ARGS['tag'], $_ARGS['attribute'] );
        $tagContent = ( !empty( $_ARGS['content']) ) ? $_ARGS['content'] : '';
        $tagClose = ( ( $this->validTagType( $_ARGS['tag'] ) === 'block') ) ? sprintf( '</%s>', $_ARGS['tag'] ) : '';

        return  $this->parseMinify( sprintf( '%s%s%s', $tag, $tagContent, $tagClose ) );
    }

    public function parseConcatAttribute( $_ARRAY )
    {
        $array  = $_ARRAY;

        $attribute = '';

        if ( count( $array ) === 0 ) return $attribute;

        foreach( $array as $key => $value )
        {
            if ( isset( $value[ 'key' ] ) && isset( $value[ 'value' ] ) ) $attribute .= sprintf( ' %s%s%s', $value[ 'key' ], $value[ 'separator' ], ( !empty( $value[ 'value' ] ) ) ? '\''.$value[ 'value' ].'\'': '' );
        }

        return $attribute;
    }

    /**
    * Valid assoc. array key/value pairs.
    *
    * Recieves an assoc. array and checks that it contains the appropriate key / value pairs required for associate methods.
    *
    * @see {array} $tags.
    * @since 1.0.0.
    * @param @{array} $_ARGS {
    *       @type {array} 'regexTags' is a list (enum) of key strings.
    * }
    * @return {bool} Return bool if param contains correct pairs.
    */
    public function validTag( $_ARGS )
    {
        if ( !isset( $_ARGS['regexTag'] ) ) throw new \Exception( $self::ERROR_TAG_MISSING );
        if ( gettype( $_ARGS['regexTag'] ) !== 'array' ) throw new \Exception( $self::ERROR_TAG_NOT_ARRAY );
    }

    /**
    * Valid assoc. array key/value pairs.
    *
    * Recieves an assoc. array and checks that it contains the appropriate key / value pairs required for associate methods.
    *
    * @see {array} $tags.
    * @since 1.0.0.
    * @param @{array} $_ARGS {
    *       @type {string} 'regexContent' strong of html and/or plain text content.
    * }
    * @return {bool} Return bool if param contains correct pairs.
    */
    public function validContent( $_ARGS )
    {
        if ( !isset( $_ARGS['regexContent'] ) ) throw new \Exception( ERROR_TAG_CONTENT_MISSING );
        if ( gettype( $_ARGS['regexContent'] ) !== 'string' ) throw new \Exception( ERROR_TAG_CONTENT_NOT_STRING );
    }

    public function validTagType( $_TAG )
    {
        $block = [
            'article', 'address', 'aside', 'body', 'blockquote', 'canvas',
            'dd', 'div', 'dl', 'dt', 'fieldset', 'figure', 'footer',
            'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'hr', 'html',
            'li', 'main', 'nav', 'noscript', 'ol', 'p', 'pre', 'section',
            'table', 'tfoot', 'ul', 'video'
        ];

        $inline = [
            'a', 'abbr', 'acronym', 'b', 'bdo', 'big', 'br', 'button', 'cite', 'code', 'dfn', 'em', 'i', 'img', 'input', 'kbd', 'label', 'map', 'object', 'output', 'q', 'samp', 'script', 'select', 'small', 'span', 'strong', 'sub', 'sup', 'textarea', 'time', 'tt', 'var', 
        ];

        return ( in_array( $_TAG, $block ) ) 
            ? 'block'
            : ( ( in_array( $_TAG, $inline ) )
                ? 'inline'
                : null );
    }


}