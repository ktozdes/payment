@extends('layouts.app')

@section('title')
    {{ __('Create Payment') }}
@endsection

@section('content')
<div class="content-wrapper container-fluid">
    <form method="post" action="{{ route('payment.store') }}">
    @csrf
        <div class="row mt-5 justify-content-md-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Create Payment') }}
                    </div>
                    <div class="px-3 py-3">
                        <x-text type="text" name="full_name" :label="__('Full name')" :value="old('full_name')" ></x-text>
                        <x-text type="text" name="phone" :label="__('Phone')" :value="old('phone')" ></x-text>
                        <x-text type="email" name="email" :label="__('Email')" :value="old('email')" ></x-text>
                        <x-currency type="text" name="amount" :label="__('Amount')" :value="old('amount')" ></x-currency>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn-primary btn">{{ __('Create Payment') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
