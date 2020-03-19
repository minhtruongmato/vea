@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <h1>
            <a href="{{ url('admin/profile')  }}">{{ __('Hồ sơ') }}</a>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href=""><i class="fa fa-dashboard"></i> Home</a>
            </li>
            <li class="active">
                <a href="{{ url('admin/profile')  }}">{{ __('Hồ sơ') }}</a>
            </li>
        </ol>
    </section>
    <br>
    <br>
    <div class="row">
    <div class="col-md-12">
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
            <div class="panel-heading">{{ __('Hồ sơ') }}</div>
            <div class="panel-body">
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.postProfile') }}" class="form-horizontal">
                    @csrf
                    <div class="box-body">
                        @if(!empty($user->avatar))
                        <div class="form-group">
                            <label for="avarta" class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-10">
                                <img src="{{ asset('storage/app/'. $user->avatar) }}" width="100%" />
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="avarta" class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-10">
                                <input type="file" name="avatar" value="{{ old('avatar') }}" class="" id="image">
                                <input type="hidden" id="url" value="{{ url('admin/profile/') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{ __('Họ Tên') }}</label>

                            <div class="col-sm-10">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-sm-10">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="coin" class="col-sm-2 control-label">{{ __('SCoin') }}</label>

                            <div class="col-sm-10">
                                <input id="coin" type="text" class="form-control{{ $errors->has('coin') ? ' is-invalid' : '' }}" name="coin" value="{{ $user->coin }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank" class="col-sm-2 control-label">{{ __('Ngân Hàng') }}</label>

                            <div class="col-sm-10">
                                <input id="bank" type="text" class="form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" name="bank" value="{{ $user->bank }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank_code" class="col-sm-2 control-label">{{ __('Số Tk Ngân Hàng') }}</label>

                            <div class="col-sm-10">
                                <input id="bank-code" type="text" class="form-control{{ $errors->has('bank_code') ? ' is-invalid' : '' }}" name="bank_code" value="{{ $user->bank_code }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ url('admin') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-info pull-right">{{ __('Cập nhật') }}</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
    </div>
    </div>
@endsection
