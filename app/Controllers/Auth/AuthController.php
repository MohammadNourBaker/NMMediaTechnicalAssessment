<?php

namespace App\Controllers\Auth;


use App\Controllers\BaseController;
use App\Repositories\Auth\AuthRepository;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use ReflectionException;

class AuthController extends BaseController
{
    protected $helpers = ['form'];
    protected AuthRepository $authRepository;
    public function __construct()
    {
        $this->authRepository = new AuthRepository();
    }

    /**
     * Displays the form the login to the site.
     *
     * @return RedirectResponse|string
     */
    public function loginView(): string|RedirectResponse
    {
        return view('auth/login');
    }

    /**
     * Attempts to log the user in.
     */
    public function loginAction(): RedirectResponse
    {
        $validation = Services::validation();
        if (!$validation->run($this->request->getPost(), 'login')) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }
        $user = $this->authRepository->login(
            $this->request->getPost(array_keys($validation->getRules()))
        );
        if ($user['is_admin']) {
            return redirect()->to('admin/dashboard')->withCookies();
        }
        return redirect()->to('client/chat')->withCookies();
    }

    /**
     * Logs the current user out.
     */
    public function logoutAction(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('auth/login')
            ->with('message', 'Logged out successfully.');
    }

    /**
     * Displays the registration form.
     *
     * @return RedirectResponse|string
     */
    public function registerView()
    {
        return view('auth/register');
    }

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        $validation = Services::validation();
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        if (!$validation->run($this->request->getPost(), 'registration')) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }
        $user = $this->authRepository->register(
            $this->request->getPost(array_keys($validation->getRules()))
        );
        return redirect()->to('auth/verify-email')->withCookies()
            ->with('message', 'registration successfully');
    }


    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @param null $id
     * @return mixed
     * @throws ReflectionException
     */
    public function update($id = null): mixed
    {
        $this->authRepository->update($this->request->getPost(), $id);
        return redirect()->back();
    }

    public function verifyView(): string
    {
        $this->authRepository->sendOTP();
        return view('auth/verify');
    }

    public function verifyEmail()
    {
        $validation = Services::validation();
        if (!$validation->run($this->request->getPost(), 'verifyemail')) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }
        if ($this->authRepository->verifyEmail(
            $this->request->getPost(array_keys($validation->getRules()))['otp_code']
        )) {
            if (session()->get('is_admin')) {
                return redirect()->to('admin/dashboard')->withCookies();
            }
            return redirect()->to('client/chat')->withCookies();
        }
        else {
            return redirect()->back()->withInput()->with('validation', 'the otp is not correct');
        }
    }

    public function sendOtp(): RedirectResponse
    {
        $this->authRepository->sendOTP();
        return redirect()->back()->with('sent', 'Otp has been sent');
    }
}
