<?php
/**
 * User: tanchik194
 * Date: 07.12.12
 */

class AbstractRequest
{
    /**
     * @const string METHOD constant names
     */
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_GET     = 'GET';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_TRACE   = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_PATCH   = 'PATCH';

    /**
     * @const string TYPE constant name
     */
    const TYPE_HTML   = 'text/html';
    const TYPE_PLAIN  = 'text/plain';
    const TYPE_PHP    = 'application/php';
    const TYPE_CSS    = 'text/css';
    const TYPE_JS     = 'application/javascript';
    const TYPE_JSON   = 'application/json';
    const TYPE_XML    = 'application/xml';
    const TYPE_RSS    = 'application/rss+xml';
    const TYPE_ATOM   = 'application/atom+xml';
    const TYPE_GZ     = 'application/x-gzip';
    const TYPE_TAR    = 'application/x-tar';
    const TYPE_ZIP    = 'application/zip';
    const TYPE_GIF    = 'image/gif';
    const TYPE_PNG    = 'image/png';
    const TYPE_JPG    = 'image/jpeg';
    const TYPE_ICO    = 'image/x-icon';
    const TYPE_SWF    = 'application/x-shockwave-flash';
    const TYPE_FLV    = 'video/x-flv';
    const TYPE_AVI    = 'video/mpeg';
    const TYPE_MPEG   = 'video/mpeg';
    const TYPE_MPG    = 'video/mpeg';
    const TYPE_MOV    = 'video/quicktime';
    const TYPE_MP3    = 'audio/mpeg';
    const TYPE_STREAM = 'application/octet-stream';

    /**
     * @var string
     */
    protected $_method = self::METHOD_GET;

    /**
     * @var array
     */
    protected $_params = array();

    /**
     * @var string
     */
    protected $_uri = null;

    /**
     * String of host.
     *
     * @var string
     */
    protected $_host = null;

    /**
     * String of content.
     *
     * @var string
     */
    protected $_content = null;

    /**
     * String of contentType.
     *
     * @var string
     */
    protected $_contentType = self::TYPE_STREAM;

    /**
     * Array of valid schemes.
     *
     * @var array
     */
    protected static $validSchemes = array(
        'http',
        'https'
    );

    /**
     * List of default ports per scheme.
     *
     * @var array
     */
    protected static $defaultPorts = array(
        'http'  => 80,
        'https' => 443
    );

    /**
     * @param string $uri (required)
     * @param array $params (optional)
     * @param string $method (optional | default self::METHOD_GET)
     * @param string $content (optional)
     * @param string $contentType (optional | default self::TYPE_STREAM)
     */
    public function __construct ($uri
        , $params = array()
        , $method = self::METHOD_GET
        , $content = null
        , $contentType = self::TYPE_STREAM
    )
    {
        if (empty($method)) {
            $this->setMethod(self::METHOD_GET);
        } else {
            $this->setMethod($method);
        }

        if (!empty($params)) {
            $this->setParams($params);
        }

        if (empty($content) && ($this->_method === self::METHOD_POST || $this->_method === self::METHOD_PUT)) {
            throw new Exception(sprintf("Parameter content is required for method %s.", $this->_method));
        } else {
            $this->setContent($content);
        }

        if (empty($contentType)) {
            $this->setContentType(self::TYPE_STREAM);
        } else {
            $this->setContentType($contentType);
        }

        if (empty($uri)) {
            throw new Exception("Parameter uri is required.");
        } else {
            $this->setUri($uri);
        }
    }

    /**
     * Set the method for this request
     *
     * @param string $method
     * @return Request
     */
    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }


    /**
     * Set the params for this request
     *
     * @param $params
     * @return Request
     */
    public function setParams($params)
    {
        $this->_params = http_build_query($params);
        return $this;
    }

    /**
     * Sets request content
     *
     * @param $content
     * @return Request
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * Sets request content type
     *
     * @param string $contentType
     * @return Request
     */
    public function setContentType($contentType)
    {
        $this->_contentType = $contentType;
        return $this;
    }

    /**
     * Set the URI/URL for this request
     *
     * @param string $uri
     * @return Request
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
        return $this;
    }
}