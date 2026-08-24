<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }
};
?>

<div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">

        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input wire:model="form.email" id="email" class="mt-1 block w-full" type="email" name="email"
                required autofocus autocomplete="username" />

            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="mt-4 block">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">

                <span class="ms-2 text-sm text-gray-600">
                    {{ __('Remember me') }}
                </span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-end">

            <x-primary-button class="ms-3">
                {{ __('Ingresar') }}
            </x-primary-button>

        </div>

    </form>
</div>
