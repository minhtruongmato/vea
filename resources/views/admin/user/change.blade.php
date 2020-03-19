@extends('admin.layouts.master')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Đổi Mật Khẩu</h1>
    </div>
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

            <div class="panel panel-success">
                <div class="panel-body">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('admin.postChangePassword') }}"  class="form-horizontal">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="current_password" class="col-sm-4 control-label">{{ __('Mật khẩu cũ') }}</label>

                                <div class="col-sm-12">
                                    <input id="current-password" type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" value="{{ old('current_password') }}" autofocus>

                                    @if ($errors->has('current_password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-sm-4 control-label">{{ __('Mật khẩu mới') }}</label>

                                <div class="col-sm-12">
                                    <input id="new-password" type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" value="{{ old('new_password') }}" >

                                    @if ($errors->has('new_password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation" class="col-sm-4 control-label">{{ __('Xác nhận mật khẩu mới') }}</label>

                                <div class="col-sm-12">
                                    <input id="new-password-confirm" type="password" class="form-control{{ $errors->has('new_password_confirmation') ? ' is-invalid' : '' }}" name="new_password_confirmation"  value="{{ old('new_password_confirmation') }}">

                                    @if ($errors->has('new_password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ url('admin') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-info pull-right">{{ __('Cập Nhật') }}</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>


@endsection