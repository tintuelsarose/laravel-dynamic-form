@extends('adminlte::page')
@section('title', 'Manage Forms')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Forms</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Manage Forms</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Forms</h3>
            </div>
            <div class="card-body">
                <p>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Generate Form</button>
                </p>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">Sl.No</th>
                            <th style="width: 100px">Name</th>
                            <th style="width: 100px">Active</th>
                            <th style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $number = 0;
                        @endphp
                        @if($data->isNotEmpty())
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ ($data->firstItem() + $number) }}</td>
                            <td>{{ $item->form_name }}</td>
                            <td>{{ $item->active == 1 ? 'Yes' : 'No'}}</td>
                            <td>
                                <a href="{{ route('form.add-attributes', ['id' => $item->id]) }}" title="Edit" class="btn-edit" target=_blank><i class="fas fa-edit"></i></a>
                                <a href="{{ route('form.show', ['id' => $item->id]) }}" title="Show" class="btn-view" target=_blank><i class="fas fa-eye"></i></a>

                            </td>

                        </tr>
                        @php
                        $number++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $data->render() }}
            </div>
            @else
            <div class="msg-content">
                No matching results found!
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
            {!! Form::open(['route' => ['form.save'],'method'=>'post','id'=>'add-form']) !!}
            @csrf
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Form Name:</strong>
                            {!! Form::text('form_name', null, ['placeholder' => 'Form Name','class' => 'form-control','id'=>'form-name', 'required' => true]) !!}
                            <span id="form_name-error" class="error invalid-feedback"></span>

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

@stop