@extends('layouts.app')
@section('content')
@php
use App\Models\Forms;
@endphp
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Form List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/login') }}">Admin Login</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
           
            <div class="col-12 col-lg-12 col-xl-9">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                    @if (Session::has('message'))

<div class="alert alert-info">{{ Session::get('message') }}</div>

@endif
                        <table>
                            <thead>
                            
                            </thead>
                            <tbody>
                                @php
                                $forms = Forms::where('active', 1)->get();
                                
                                @endphp
                                @foreach($forms as $form)
                                <tr>
                                    <td>
                                        <a href="{{ route('form.show', ['id' => $form->id]) }}">{{ $form->form_name }}</a>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection