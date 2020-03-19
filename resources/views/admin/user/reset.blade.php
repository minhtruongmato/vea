@extends('admin.user.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cập nhật mật khẩu mật khẩu</div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.postResetPassword', ['token' => $token]) }}">
                            {{ csrf_field() }}


                            <div class="form-group row">
                                <label for="new-password" class="col-md-4 control-label text-md-right">Mật khẩu mới</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" value="{{ old('new_password') }}" >

                                    @if ($errors->has('new_password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-md-4 control-label text-md-right">Xác nhận mật khẩu mới</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control{{ $errors->has('new_password_confirmation') ? ' is-invalid' : '' }}" name="new_password_confirmation"  value="{{ old('new_password_confirmation') }}">

                                    @if ($errors->has('new_password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Cập Nhật
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