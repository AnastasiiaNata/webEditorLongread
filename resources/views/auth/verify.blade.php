@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтверждение вашей электронной почты') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Ссылка была отправлена на вашу почту') }}
                        </div>
                    @endif

                    {{ __('До отправки проверьте, пожалуйста, ваш электронный адрес') }}
                    {{ __('Если вы не получили ссылку') }}, <a href="{{ route('verification.resend') }}">{{ __('отправьте запрос еще раз') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
