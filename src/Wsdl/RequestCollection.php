<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.0
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClass\Wsdl;

/**
 * The request collection is used to group all the requests in a single object
 */
class RequestCollection extends ArrayCollection
{
    /**
     * RequestCollection constructor.
     * @param Request[] ...$requests
     */
    public function __construct(Request ...$requests)
    {
        foreach ($requests as $request) {
            $this->add($request);
        }
    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        $this->addItem($request->getName(), $request);
    }
}
