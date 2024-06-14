@extends('layouts.app')
@section('content')
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
                            {!! Form::open(['url' => ['form/submit-form'],'method'=>'POST','id'=>'submit-form']) !!}
                            @csrf
                            <div class="card-body">
                                @foreach ($formAttributes as $formItems)
                                <div class="form-group">
                                    <label>{{ $formItems->label }}</label>
                                    @if ($formItems->type == 'select')
                                    {!! Form::{$formItems->type}($formItems->name, $formItems->getFieldAttributes()->pluck('value', 'label'), null, ['placeholder' => 'Select ' . $formItems->label,'class' => 'form-control', 'required' => true]) !!}
                                    @else
                                    {!! Form::{$formItems->type}($formItems->name, null, ['placeholder' => $formItems->label,'class' => 'form-control', 'required' => true]) !!}
                                    @endif

                                </div>
                                {!! Form::hidden('id_form', $data->id) !!}
                                @endforeach
                            </div>

                            <div class="card-footer clearfix">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection