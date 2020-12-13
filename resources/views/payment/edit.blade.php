@extends('layouts.app')

@section('title')
    {{ __('Payment Details') }}
@endsection

@section('content')
<div class="content-wrapper container-fluid">

    <div class="row mt-5">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ __('Payment') }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ __('Full name') }}: {{ $item->full_name }}</li>
                    <li class="list-group-item">{{ __('Phone') }}:  {{ $item->phone }}</li>
                    <li class="list-group-item">{{ __('Email') }}:  {{ $item->email }}</li>
                    <li class="list-group-item">{{ __('Payed At') }}:  {{ isset($item->payed_at) ? $item->payed_at->format('d/m/Y') : __('Not paid yet') }}</li>
                    <li class="list-group-item">{{ __('Unique link') }}:  {{ $item->token }}</li>
                </ul>
                <div class="card-footer">
                    {{ __('Current Status') }}: {{ isset($item->current_status) ? $item->current_status->name : 'No history' }}<br/>
                    {{ __('Amount') }}: {{ $item->currency }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <form method="post" action="{{ route('payment.update', $item->id) }}">
                @csrf
                <x-payment-card></x-payment-card>
                </form>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ __('Status History') }}
                </div>
                <ul class="list-group list-group-flush">
                @foreach($histories as $history)
                <li class="list-group-item">{{ __('Status') }}: {{ $history->status->name }} <br/>
                        {{ __('Date') }}: {{ $history->created_at->format('d/m/Y') }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
