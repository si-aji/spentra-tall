<?php

namespace App\Http\Livewire\Adm\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    /** @var string */
    public $user_timezone = '';
    public $user_timezone_offset = '';

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        $userKey = $this->usernameKeyValidate() ?? 'email';
        if (!Auth::guard('adm')->attempt([$userKey => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        $globalProperties = new \App\Http\Livewire\GlobalProperties();
        $globalProperties->setUserTimezone($this->user_timezone, $this->user_timezone_offset);

        return redirect()->intended(route('adm.index'));
    }

    public function render()
    {
        return view('livewire.adm.auth.login')->extends('layouts.auth');
    }

    /**
     * Validate User Key, sign-in use username/email
     * 
     */
    private function usernameKeyValidate()
    {
        // $key = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';;
        $key = 'email';
        return $key;
    }
}
