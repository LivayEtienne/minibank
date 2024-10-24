<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
       /* return [
            'telephone' => [
                'required',
                'string',
                'regex:/^[0-9]{9}$/', // Format de numéro de téléphone à 9 chiffres
                'unique:users,numero', // Doit être unique dans la table 'users'
                'min:8',
                'max:255',
            ],
            'password' => ['required', 'string'],
        ];*/

        return [
            'telephone' => 'required|string|size:9|regex:/^[0-9]+$/', // Vérifie que le numéro de téléphone a exactement 9 chiffres
            'password' => 'required|string|min:6', // Vérifie que le mot de passe a au moins 6 caractères
        ];
    }

    

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('telephone', 'password');
        
        // Vérifiez que le numéro de téléphone est présent dans les informations d'identification
        if (!isset($credentials['telephone'])) {
            throw ValidationException::withMessages([
                'telephone' => 'Le numéro de téléphone est requis.',
            ]);
        }

        // Vérifiez que le mot de passe est présent dans les informations d'identification
        if (!isset($credentials['password'])) {
            throw ValidationException::withMessages([
                'password' => 'Le mot de passe est requis.',
            ]);
        }

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'telephone' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        if (!isset($credentials['password'])) {
            throw ValidationException::withMessages([
                'password' => 'Le mot de passe est requis.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            event(new Lockout($this));
            $seconds = RateLimiter::availableIn($this->throttleKey());
    
            // Ajoutez ici un code pour afficher un CAPTCHA
            throw ValidationException::withMessages([
                'telephone' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('number')).'|'.$this->ip());
    }
}
