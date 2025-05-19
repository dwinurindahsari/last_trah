<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        $user->assignrole('user');

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

@section('styles')
    <!-- Load custom auth page styles -->
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

<div class="auth-wrapper">
    <div class="auth-inner">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo mb-4 text-center">
                <a href="{{ url('/') }}" class="d-flex flex-column align-items-center text-decoration-none">
                    <span class="logo-icon mb-2">@include('_partials.macros', ["width" => 40, "withbg" => 'var(--bs-primary)'])</span>
                    <span class="logo-text fs-3 fw-bold text-dark">{{ config('variables.templateName') }}</span>
                </a>
            </div>

            <form wire:submit.prevent="register" class="auth-form">
                <!-- Name Input -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input wire:model="name" type="text" class="form-control" id="name" placeholder="Enter your name" autofocus>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input wire:model="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-3 password-toggle">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input wire:model="password" type="password" id="password" class="form-control" placeholder="············">
                        <span class="input-group-text toggle-password"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3 password-toggle">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input wire:model="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="············">
                        <span class="input-group-text toggle-password"><i class="bx bx-hide"></i></span>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-4">
                    <div class="form-check">
                        <input wire:model="terms" class="form-check-input" type="checkbox" id="terms">
                        <label class="form-check-label" for="terms">
                            I agree to <a href="#">privacy policy & terms</a>
                        </label>
                    </div>
                    @error('terms') <div class="text-danger small">You must accept the terms</div> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">
                    Sign up
                </button>
            </form>

            <div class="auth-footer text-center mt-3">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}" wire:navigate>Sign in instead</a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!-- Password toggle functionality -->
    <script>
        document.addEventListener('livewire:init', () => {
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('bx-hide', 'bx-show');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('bx-show', 'bx-hide');
                    }
                });
            });
        });
    </script>
@endsection

{{-- <div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div> --}}
