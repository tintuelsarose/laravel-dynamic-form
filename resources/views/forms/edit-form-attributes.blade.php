@extends('adminlte::page')
@section('title', 'Form Field')
@section('content')
@php
use App\Models\FormAttributes;
@endphp
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Form Fields</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Form Field</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit fields for {{$formAttributes->form_name}}</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['url' => ['form/update-attributes'],'method'=>'POST','id'=>'update-attributes']) !!}
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', $formAttributes->name, ['placeholder' => 'Field Name','class' => 'form-control','id'=>'field-name', 'required' => true]) !!}
                                <span id="name-error" class="error invalid-feedback"></span>

                            </div>
                            <div class="form-group">
                                <strong>Label:</strong>
                                {!! Form::text('label', $formAttributes->label, ['placeholder' => 'Field Label','class' => 'form-control','id'=>'field-label', 'required' => true]) !!}
                                <span id="label-error" class="error invalid-feedback"></span>

                            </div>
                            <div class="form-group">
                                <strong>Type:</strong>
                                {!! Form::select('type', FormAttributes::FieldType(), $formAttributes->type, ['placeholder' => 'Select Field Type','class' => 'form-control','id'=>'field-type', 'required' => true]) !!}
                                <span id="type-error" class="error invalid-feedback"></span>
                            </div>

                            @if($formAttributes->type == 'select')
                            @php
                            $fields = $formAttributes->getFieldAttributes;
                            @endphp
                            @foreach($fields as $field)
                            <div class="row">
                                <div class="form-group col-md-6">
                                {!! Form::text("option_name[$field->id]", $field->value, ['placeholder' => 'Field Label','class' => 'form-control','id'=>'field-label', 'required' => true]) !!}
                                </div>
                                <div class="form-group col-md-6">
                                {!! Form::text("option_value[$field->id]", $field->label, ['placeholder' => 'Field Label','class' => 'form-control','id'=>'field-label', 'required' => true]) !!}
                                </div>
                            </div>
                            
                            @endforeach
                            @endif
                            {!! Form::hidden('id_form_attribute',$formAttributes->id) !!}
                            {!! Form::hidden('id_form',$formAttributes->id_forms) !!}
                            <div id="add-more" class="hide">
                                <div id="fields-container">
                                    <div class="clone-wrapper">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="option_name[]" placeholder="Option Name" class="form-control clone-field">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="option_value[]" placeholder="Option Value" class="form-control clone-field">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="add-button" class="btn btn-primary btn-sm">Add More Fields</button>
                                    <button type="button" id="remove-button" class="remove-button btn btn-danger btn-sm">Remove Last Fields</button>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</section>

<style>
    .clone-wrapper {
        margin-bottom: 10px;
    }

    .remove-button {
        display: none;
    }

    .hide {
        display: none;
    }

    .show {
        display: block;
    }
</style>
@stop
@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        // $('#field-type').on('change', function() {
        //     console.log('hi');
            if ($('#field-type').val() == 'select') {
                $('#add-more').removeClass('hide');
                $('#add-more').addClass('show');
                // $('.clone-field').prop('required', true);
                $('.remove-button').show();
            } else {
                $('.clone-field').prop('required', false);
            }
        // });
        $('#field-type').on('change', function() {
            console.log('hi');
        if ($('#field-type').val() == 'select') {
                $('#add-more').removeClass('hide');
                $('#add-more').addClass('show');
                // $('.clone-field').prop('required', true);
                $('.remove-button').show();
            } else {
                $('.clone-field').prop('required', false);
            }
        });
        $('#add-button').click(function() {
            var clonedFields = $('.clone-wrapper:first').clone();
            clonedFields.find('input').val(''); // Clear input values in cloned fields
            $('#fields-container').append(clonedFields);
            $('#remove-button').show();
        });

        $('#remove-button').click(function() {
            $('.clone-wrapper:last').remove();
            if ($('.clone-wrapper').length === 1) {
                $('#remove-button').hide();
            }
        });

        // Initially hide the remove button if there's only one set of fields
        if ($('.clone-wrapper').length === 1) {
            $('#remove-button').hide();
        }
    });
</script>
@stop