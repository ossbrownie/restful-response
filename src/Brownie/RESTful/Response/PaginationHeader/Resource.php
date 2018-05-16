<?php
/**
 * @category    Brownie\RESTful\Response
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\RESTful\Response\PaginationHeader;

class Resource
{

    const HEADER_NAME = 'Access-Control-Expose-Headers';

    const CURRENT_PAGE = 'X-Pagination-Current-Page';

    const PAGE_COUNT = 'X-Pagination-Page-Count';

    const PER_PAGE = 'X-Pagination-Per-Page';

    const TOTAL_COUNT = 'X-Pagination-Total-Count';

    private $headers = [];

    public function __toString()
    {
        return implode(', ', $this->headers);
    }

    public function add($headerName)
    {
        $this->headers[] = $headerName;
        return $this;
    }
}
