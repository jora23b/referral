@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Current Balance</label>
                        <div class="col-md-6"><label class="col-md-4 col-form-label text-md-left">{{ $user->balance }}</label></div>
                    </div>
                    @if(!$user->isReferral())
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Referral Link</label>
                            <div class="col-md-6"><label class="col-form-label text-md-left">{{ $user->referralLink() }}</label></div>
                        </div>
                    @endif
                </div>

                <div class="card-header">Update Balance</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('update-balance') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Update Balance</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
