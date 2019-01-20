<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return view('profile', compact('user'));
    }

    public function updateBalance(BalanceRequest $balanceRequest, UserService $userService)
    {
        $userService->updateBalance($balanceRequest->user(), $balanceRequest->get('amount'));

        return redirect(route('profile'));
    }
}
