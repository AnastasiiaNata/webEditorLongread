@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Регистрация') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                                

                                <div class="col-md-6 form-group-input">
                                    <input ng-model="input_name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >
                                    <label for="name" class="col-md-4 col-form-label text-md-right" ng-class="(input_name.length > 0) ? 'up' : ''">{{ __('Имя') }}</label>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-6 form-group-input">
                                <input id="email" ng-model="input_email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                <input id="password" ng-model="input_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
                                <input id="password-confirm" ng-model="input_password_confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right" ng-class="(input_password_confirm.length > 0) ? 'up' : ''">{{ __('Подтвердите пароль') }}</label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 new_section_button">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Зарегистрироваться') }}
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
