<?php
/**
 * Created by PhpStorm.
 * User: jorj
 * Date: 20.01.2019
 * Time: 12:56
 */

namespace App\Services;


use App\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $inputs)
    {
        $data = [
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
        ];

        if (!empty($inputs['referral_token']) && $user = $this->getUserByReferralToken($inputs['referral_token'])) {
            $data['user_id'] = $user->id;
        } else {
            $data['referral_token'] = Hash::make(time() . uniqid());
        }

        return User::create($data);
    }

    public function updateBalance(User $user, $amount)
    {
        if ($user->isReferral()) {
            //convert to cents
            $amount *= 100;

            //calc percent (10%)
            $parentUserAmount = ceil($amount * 0.1);

            //extract percent
            $amount -= $parentUserAmount;

            //convert from cents
            $amount = $amount / 100;
            $parentUserAmount = $parentUserAmount / 100;

            $parentUser = $user->parent;
            $parentUser->balance += $parentUserAmount;
            $parentUser->save();
        }

        $user->balance += $amount;
        $user->save();
    }

    public function getUserByReferralToken($token): User
    {
        return User::where('referral_token', $token)->first();
    }
}