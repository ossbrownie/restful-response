<?php
/**
 * @category    Brownie\RESTful\Response
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\RESTful\Response\Hal;

use IteratorAggregate;
use ArrayIterator;
use Traversable;

class ResourceCollection implements IteratorAggregate
{

    private $collections = [];

    public function __construct(array $collection = [])
    {
        foreach ($collection as $resource) {
            if (!($resource instanceof Resource)) {
                throw new InvalidArgumentException('The argument must be of class ' . Resource::class);
            }
            $this->collections[] = $resource;
        }
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->collections);
    }

    public function add(Resource $resource)
    {
        $this->collections[] = $resource;
        return $this;
    }
}
