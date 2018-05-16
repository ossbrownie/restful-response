<?php
/**
 * @category    Brownie\RESTful\Response
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\RESTful\Response\LinkHeader;

class Resource
{

    const HEADER_NAME = 'Link';

    const LINK_SELF = 'self';

    const LINK_FIRST = 'first';

    const LINK_PREV = 'prev';

    const LINK_NEXT = 'next';

    const LINK_LAST = 'last';

    private $links = [];

    public function __toString()
    {
        return implode(', ', $this->links);
    }

    public function add($key, $url)
    {
        $this->links[] = '<' . $url . '>; rel="' . $key . '"';
        return $this;
    }
}
