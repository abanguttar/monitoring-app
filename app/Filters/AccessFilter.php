<?php

namespace App\Filters;

use Myth\Auth\Filters\BaseFilter;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AccessFilter extends BaseFilter implements FilterInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        if ((int) $this->authenticate->user()->tipe !== 999) {
            $user = $this->db->table('user_permissions')->where('user_id', (int)$this->authenticate->user()->id)->get()->getResultArray();
            /**
             * Collect all permissions user have
             */
            $permissions = array_map(function ($x) {
                return (int) $x['permission_id'];
            }, $user,);

            /**
             * Check is user have the permissions?
             */
            if (!in_array((int) $arguments[0], $permissions)) {
                return redirect()->back()->with('errors', ['User not have access to this page!']);
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
