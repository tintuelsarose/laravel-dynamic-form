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
                <h3 class="card-title">Add fields for {{$formData->form_name}}</h3>
            </div>
            @if (Session::has('message'))

            <div class="alert alert-info">{{ Session::get('message') }}</div>

            @endif
            <div class="card-body">
                <p>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add Fields</button>
                </p>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">Sl.No</th>
                            <th>Label</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @php
                        $number = 1;

                        @endphp
                        @if($formData)
                        @foreach ($formData->getFormAttributes as $key => $item)
                        <tr>
                            <td>{{ $number }}</td>
                            <td>{{ $item->label }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type }}</td>
                            <!-- <td>{{ $item->active == 1 ? 'Yes' : 'No'}}</td> -->
                            <td>
                                <!-- <button type="button" class="btn btn-primary"  data-id="{{$item->id}}" id="edit-btn">Edit</button> -->
                                <!-- <a href="#" title="Edit" class="btn-edit" id="edit-btn" data-id="{{$item->id}}"><i class="fas fa-edit"></i></a> -->
                                <a href="{{ route('form.editFormAttribute', ['id' => $item->id]) }}"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('form.deleteAttribute', ['id' => $item->id]) }}" onclick="return confirm('Are you sure you want to delete this attribute?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @php
                        $number++;
                        @endphp
                        @endforeach
                    </tbody>
                    </tbody>
                </table>
            </div>
            @else
            <div class="msg-content">
                No results found!
            </div>
            @endif
        </div>
    </div>

</section>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <!-- <h4 class="modal-title">Modal Header</h4> -->
            </div>
            {!! Form::open(['url' => ['add-fields'],'method'=>'POST','id'=>'add-fields']) !!}
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, ['placeholder' => 'Field Name','class' => 'form-control','id'=>'field-name', 'required' => true]) !!}
                            <span id="name-error" class="error invalid-feedback"></span>

                        </div>
                        <div class="form-group">
                            <strong>Label:</strong>
                            {!! Form::text('label', null, ['placeholder' => 'Field Label','class' => 'form-control','id'=>'field-label', 'required' => true]) !!}
                            <span id="label-error" class="error invalid-feedback"></span>

                        </div>
                        <div class="form-group">
                            <strong>Type:</strong>
                            {!! Form::select('type', FormAttributes::FieldType(), null, ['placeholder' => 'Select Field Type','class' => 'form-control','id'=>'field-type', 'required' => true]) !!}
                            <span id="type-error" class="error invalid-feedback"></span>
                        </div>

                        {!! Form::hidden('id_form',$formData->id) !!}
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
                                <button id="add-button" class="btn btn-primary btn-sm">Add More Fields</button>
                                <button id="remove-button" class="remove-button btn btn-danger btn-sm">Remove Last Fields</button>
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
        setTimeout(function() {
            $("div.alert").remove();
        }, 3000);
        $('#field-type').on('change', function() {
            console.log('hi');
            if ($('#field-type').val() == 'select') {
                $('#add-more').removeClass('hide');
                $('#add-more').addClass('show');
                $('.clone-field').prop('required', true);
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