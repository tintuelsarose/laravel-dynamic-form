@extends('adminlte::page')
@section('title', 'Create Form')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Form & Fields</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Manage New Form </li>
                </ol>
            </div>
        </div>
    </div>
</div>
{{ Form::open(['route' => 'form.store', 'method' => 'POST']) }}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form & Field Details</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Name</label>
                    {{ Form::text('name', old('name'), ['placeholder' => 'Name', 'class' => ($errors->any() && $errors->first('name') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('name')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Email</label>
                    {{ Form::text('email', old('email'), ['placeholder' => 'Email', 'class' => ($errors->any() && $errors->first('email') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('email')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Address</label>
                    {{ Form::textArea('address', old('address'), ['rows' => 3, 'placeholder' => 'Address', 'class' => ($errors->any() && $errors->first('address') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('address')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Phone Number</label>
                    {{ Form::text('phone', old('phone'), ['placeholder' => 'Phone Number', 'class' => ($errors->any() && $errors->first('phone') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('phone')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>  
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Location</label>
                    {{ Form::text('location', old('location'), ['placeholder' => 'Location', 'class' => ($errors->any() && $errors->first('location') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('location')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>Total Parking</label>
                    {{ Form::text('total_parking', old('total_parking'), ['class' => ($errors->any() && $errors->first('total_parking') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('total_parking')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Fee Type</label>
                    {{ Form::select('is_paid', [1 => 'Paid', 0 => 'Free'], old('is_paid'), ['placeholder' => 'Select Fee Type', 'id' => 'fee-type', 'class' => ($errors->any() && $errors->first('is_paid') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('is_paid')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group hide-charge" id="charge">
                    <label>Charge</label>
                    {{ Form::text('charge', old('charge'), ['class' => ($errors->any() && $errors->first('charge') ? 'form-control is-invalid' : 'form-control')]) }}
                    @error('charge')
                    <span style="font-size: 12px; color:red">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" style="min-width: 130px;">Save</button>
        <a href="{{ route('parking-owner.index') }}" class="btn btn-outline-primary" style="min-width: 130px;">Cancel</a>
    </div>
</div>

{{ Form::close() }}
@stop

@section('js')
    <script>
        $('#fee-type').on('change', function(){
            if ($(this,':selected').val() == 1) {
                $('#charge').removeClass('hide-charge');
            } else {
                $('#charge').addClass('hide-charge');
            }
        });
    </script>
@stop
