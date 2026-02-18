<?php

namespace App\Http\Controllers;

use App\Core\Services\UserService;

class HomeController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $message = $this->userService->getWelcomeMessage();
        return view('home', compact('message'));
    }
}
