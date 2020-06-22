@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Восстановление пароля') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            

                            <div class="col-md-6 form-group-input">
                                <input id="email" type="text" ng-model="input_email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                                <label for="email" class="col-md-4 col-form-label text-md-right" ng-class="(input_email.length > 0) ? 'up' : ''">{{ __('Электронная почта') }}</label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-6 form-group-input">
                                <input id="password" type="password" ng-model="input_password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <label for="password" class="col-md-4 col-form-label text-md-right" ng-class="(input_password.length > 0) ? 'up' : ''">{{ __('Пароль') }}</label>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 form-group-input">
                                <input id="password-confirm" type="password" class="form-control"  ng-model="input_password_confirm" name="password_confirmation" required autocomplete="new-password">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right" ng-class="(input_password_confirm.length > 0) ? 'up' : ''">{{ __('CПодтвердите пароль') }}</label>
                                
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 new_section_button">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Восстановить пароль') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
