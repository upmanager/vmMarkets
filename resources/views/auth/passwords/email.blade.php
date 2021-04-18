@extends('layouts2.app')

@section('content')


        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="msg">{{ __('Reset Password') }}</div>
            <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                <div class="form-line">
                    <div class="col-md-12">
                        <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div align="center">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                    </button>
                    </div>
                </div>
            </div>


        </form>


@endsection
