<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class VerifyEmailNotRequired implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        if(session()->get('has_verify_email')){
            if (session()->get('is_admin')) {
                return redirect()->to('admin/dashboard')->withCookies();
            }
            return redirect()->to('client/chat')->withCookies();
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
