<?php
/**
 * User: tanchik194
 * Date: 06.12.12
 */
require_once 'AbstractRequest.php';

class Request extends AbstractRequest
{
    public function send()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->_method);
        curl_setopt($ch, CURLOPT_URL, $this->_uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if (in_array($this->_method, array('PUT', 'POST'))) {

            $content = $this->_content;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            if(is_string($content)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type:' . $this->_contentType,
                        'Content-Length:' . strlen($content)
                    )
                );
            }
        }

        $body = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = explode(';', curl_getinfo($ch, CURLINFO_CONTENT_TYPE));

        $contentType = current($info);
        $charset = null;

        if (count($info) === 2) {
            $charset = trim(str_replace('charset=', '', end($info)));
        }

        curl_close($ch);

        return array(
            'code' => $code,
            'content-type' => $contentType,
            'charset' => $charset,
            'body' => $body
        );
    }

    /**
     * Takes a XML string and converts it into an array.
     *
     * @param $xml
     */
    public static function xmlToArray($xml)
    {
        // TODO
    }

    /**
     * Takes a JSON encoded string and converts it into a PHP variable.
     *
     * @param $json
     * @return mixed
     */
    public static function jsonToArray($json)
    {
        return json_decode($json);
    }

    /**
     * Is this a GET method request?
     *
     * @return bool
     */
    public function isGet()
    {
        return ($this->_method === self::METHOD_GET);
    }

    /**
     * Is this a POST method request?
     *
     * @return bool
     */
    public function isPost()
    {
        return ($this->_method === self::METHOD_POST);
    }

    /**
     * Is this a PUT method request?
     *
     * @return bool
     */
    public function isPut()
    {
        return ($this->_method === self::METHOD_PUT);
    }

    /**
     * Is this a DELETE method request?
     *
     * @return bool
     */
    public function isDelete()
    {
        return ($this->_method === self::METHOD_DELETE);
    }

    /**
     * Is this a HEAD method request?
     *
     * @return bool
     */
    public function isHead()
    {
        return ($this->_method === self::METHOD_HEAD);
    }

    /**
     * Is this a OPTIONS method request?
     *
     * @return bool
     */
    public function isOptions()
    {
        return ($this->_method === self::METHOD_OPTIONS);
    }

    /**
     * Is this a CONNECT method request?
     *
     * @return bool
     */
    public function isConnect()
    {
        return ($this->_method === self::METHOD_CONNECT);
    }

    /**
     * Is this a TRACE method request?
     *
     * @return bool
     */
    public function isTrace()
    {
        return ($this->_method === self::METHOD_TRACE);
    }

    /**
     * Is this a PATCH method request?
     *
     * @return bool
     */
    public function isPatch()
    {
        return ($this->_method === self::METHOD_PATCH);
    }
}