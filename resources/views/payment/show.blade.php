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
                    <li class="list-group-item">{{ __('Unique link') }}:  {{ 'http://localhost:8090/payment/' . $item->token }}</li>
                </ul>
                <div class="card-footer">
                    {{ __('Current Status') }}: {{ isset($item->current_status) ? $item->current_status->name : 'No history' }}<br/>
                    {{ __('Amount') }}: {{ $item->currency }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ __('Card') }}
                </div>
                @if ( $item->card)
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ __('Owner') }}: {{ $item->card->owner }}</li>
                    <li class="list-group-item">{{ __('Type') }}:  {{ $item->card->type }}</li>
                    <li class="list-group-item">{{ __('Number') }}:  {{ $item->card->number }}</li>
                    <li class="list-group-item">{{ __('Expiration date') }}:  {{ $item->card->expiration_date }}</li>
                </ul>
                @endif
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
