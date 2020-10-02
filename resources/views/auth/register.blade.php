@extends('layout.master-mini')

@push('plugin-styles')
{!! Html::style('/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') !!}
{!! Html::style('/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}

@endpush

@section('content')
<div class="content-wrapper d-flex align-items-center auth">
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="{{ url('assets/images/logo.svg') }}">
                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3">
                    <div class="form-group">
                        <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd/mm/yyyy">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    {{-- <div class="mb-4">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input"><i class="input-helper"></i> I agree to all Terms & Conditions </label>
                        </div>
                    </div> --}}
                    <div class="">
                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SUBMIT</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
{!! Html::script('/assets/plugins/moment/moment.js') !!}
{!! Html::script('/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}
{!! Html::script('/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') !!}
{!! Html::script('/assets/plugins/jqueryrepeater/jquery.repeater.min.js') !!}

@endpush

@push('custom-scripts')
{!! Html::script('/assets/js/formpickers.js') !!}
@endpush
