<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PemissionCreatePegawai implements FilterInterface
{
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
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = str_replace("Bearer ", "", $request->getServer('HTTP_AUTHORIZATION'));

        if ($token) {
            try {
                $decodedToken = JWT::decode($token, new Key(env('secretKey'), env('algorithm')));
                $permission = $decodedToken->permission;

                if (!in_array("create.pegawai", $permission)) {
                    return response()->setJSON(['message' => "Anda tidak punya akses menambah data pegawai"])->setStatusCode(400);
                }

            } catch (\Exception $e) {
                return response()->setJSON(['message' => "Silahkan login kembali"])->setStatusCode(401);
            }
        } else {
            return response()->setJSON(['message' => "Silahkan login kembali"])->setStatusCode(401);
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
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}