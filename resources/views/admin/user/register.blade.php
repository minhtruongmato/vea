@extends('admin.layouts.master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Đăng Ký</h1>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2">
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
        <!-- Horizontal Form -->
            <div class="panel panel-success">
                <div class="panel-body">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('admin.postRegister') }}" class="form-horizontal">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">{{ __('Họ Tên') }}</label>

                                <div class="col-sm-12">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-4 control-label">{{ __('E-Mail Address') }}</label>

                                <div class="col-sm-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">{{ __('Mật khẩu') }}</label>

                                <div class="col-sm-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-4 control-label">{{ __('Xác nhận mật khẩu') }}</label>

                                <div class="col-sm-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer justify-content-between">
                            <a href="{{ url('admin') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">{{ __('Register') }}</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>

@endsection
