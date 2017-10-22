@extends('layouts/master')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card text-center">
                <div class="card-header">
                  <h4 class="card-title">تغير كلمة المرور</h4>
                </div>
                <div class="panel-body">
                @if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
                <form action="" method="post" role="form" class="form-horizontal">
                    {{csrf_field()}}
 
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"><strong>كلمة المرور الحالية</strong></label>
 
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="old_password">
 
                                @if ($errors->has('old_password'))
                                    <span class="help-block alert-danger">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
 
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label"><strong>كلمة المرور الجديدة</strong></label>
 
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
 
                                    @if ($errors->has('password'))
                                        <span class="help-block alert-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
 
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label"><strong>تأكيد كلمة المرور</strong></label>
 
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
 
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block alert-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary form-control">تغير كلمة المرور</button>
                                </div>
                        </div>
                </form>
                </div>
 
            </div>
        </div>
    </div>
</div>
@endsection
