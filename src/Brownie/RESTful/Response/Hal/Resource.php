<?php
/**
 * @category    Brownie\RESTful\Response
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\RESTful\Response\Hal;

use JsonSerializable;
use InvalidArgumentException;

class Resource implements JsonSerializable
{

    const MIME_CONTENT_TYPE = 'application/hal+json; charset=UTF-8';

    const LINK_SELF = 'self';

    const LINK_FIRST = 'first';

    const LINK_PREV = 'prev';

    const LINK_NEXT = 'next';

    const LINK_LAST = 'last';

    private $jsonEncodeOptions = 0;

    private $jsonEncodeDepth = 512;

    private $resource = [];

    private $links = [];

    private $embedded = [];

    private $collections = [];

    public function toArray()
    {
        $response = $this->resource;
        if (!empty($this->links)) {
            $response['_links'] = $this->links;
        }
        if (!empty($this->embedded)) {
            $response['_embedded'] = $this->embedded;
        }
        if (!empty($this->collections)) {
            $response['_embedded'] = array_merge($this->embedded, $this->collections);
        }
        return $response;
    }

    public function __toString()
    {
        return json_encode($this->toArray(), $this->getJsonEncodeOptions(), $this->getJsonEncodeDepth());
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function validate()
    {
        if ((false === $this->__toString()) || (json_last_error() !== JSON_ERROR_NONE)) {
            throw new InvalidArgumentException(json_last_error_msg());
        }
    }

    public function setJsonEncodeOptions($jsonEncodeOptions)
    {
        $this->jsonEncodeOptions = $jsonEncodeOptions;
        return $this;
    }

    private function getJsonEncodeOptions()
    {
        return $this->jsonEncodeOptions;
    }

    public function setJsonEncodeDepth($jsonEncodeDepth)
    {
        return $this->jsonEncodeDepth = $jsonEncodeDepth;
    }

    private function getJsonEncodeDepth()
    {
        return $this->jsonEncodeDepth;
    }

    private function add($target, $key, $value)
    {
        if ('_' == $key[0]) {
            throw new InvalidArgumentException('The key can not begin with a "_"');
        }
        $this->{$target}[$key] = $value instanceof Resource ? $value->toArray() : $value;
    }

    public function addField($key, $value)
    {
        $this->add('resource', $key, $value);
        return $this;
    }

    public function addLink($key, $url)
    {
        $this->links[$key] = ['href' => $url];
        return $this;
    }

    public function addEmbedded($key, $value)
    {
        $this->add('embedded', $key, $value);
        return $this;
    }

    public function addCollection($key, $collection)
    {
        $value = [];
        foreach ($collection as $resource) {
            $value[] = $resource instanceof Resource ? $resource->toArray() : $resource;
        }
        $this->add('collections', $key, $value);
        return $this;
    }
}
