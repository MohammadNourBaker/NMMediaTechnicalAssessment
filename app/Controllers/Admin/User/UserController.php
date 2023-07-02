<?php

namespace App\Controllers\Admin\User;

use App\Repositories\User\UserRepository;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->userRepository->scope($this->request)->get();
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function create()
    {
        $this->userRepository->create($this->request->getPost());
        return redirect()->back();
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
        $this->userRepository->update($this->request->getPost(), $id);
        return redirect()->back();
    }

    /**
     * Delete the designated resource object from the model
     *
     * @param null $id
     * @return mixed
     */
    public function delete($id = null): mixed
    {
        $this->userRepository->destroy($id);
        return redirect()->back();
    }
}
