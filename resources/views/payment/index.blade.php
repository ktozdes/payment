@extends('layouts.app')

@section('title')
    {{ __('Project List') }}
@endsection

@section('content')
<div class="content-wrapper container-fluid">

    <div class="row mt-5">
        <div class="col-md-12">
            <form class="filters row">
                <div class="filter-box form-group col-md-3">
                    <input class="form-control" type="text" name="filter[token]" placeholder="{{ __('Token') }}" @if(isset($filters['token'])) value="{{$filters['token']}}" @endif/>
                </div>
                <div class="filter-box form-group col-md-3">
                    <input class="form-control" type="text" name="filter[full_name]" placeholder="{{ __('Full name') }}" @if(isset($filters['full_name'])) value="{{$filters['full_name']}}" @endif/>
                </div>
                <div class="filter-box form-group col-md-3">
                    <select class="form-control" type="text" name="filter[card_type]" placeholder="{{ __('Card type') }}">
                        <option value="0">{{__('All')}}</option>
                        <option value="Visa" @if (isset($filters['card_type']) && $filters['card_type']=='Visa') selected @endif>Visa</option>
                        <option value="MasterCard" @if (isset($filters['card_type']) && $filters['card_type']=='MasterCard') selected @endif>MasterCard</option>
                        <option value="Discover Card" @if (isset($filters['card_type']) && $filters['card_type']=='Discover Card') selected @endif>Discover Card</option>
                    </select>
                </div>
                <div class="filter-box form-group col-md-3">
                    <button type="submit" class="form-control btn btn-primary">{{ __('Search') }}</button>
                </div>
            </form>
        </div>
        <div class="col-xl">
            <h1>{{ __('Payment List') }}</h1>
            @if(count($items)  < 1)
                <div class="alert alert-dark" role="alert">
                    {{ __('No Data') }}
                </div>
            @else
                {{ $items->links() }}
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('Full name') }}</th>
                            <th scope="col">{{ __('Phone') }}</th>
                            <th scope="col">{{ __('Email') }}</th>
                            <th scope="col">{{ __('Card') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($items as $item)
                        <tr>
                            <th scope="row">
                                {{ $item->currency }}
                            </th>
                            <td>{{ $item->full_name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->card->type }}</td>
                            <td>{{ isset($item->current_status) ? $item->current_status->name : 'No history' }}</td>
                            <td class="text-right">
                                <a href="{{ route('payment.show', [$item->id]) }}" title="{{ __('Show Payment') }}" class="btn btn-sm btn-info">{{ __('Show Payment') }}</a>
                                <a href="{{ route('payment.edit', [$item->id]) }}" title="{{ __('Edit Payment') }}" class="btn btn-sm btn-secondary">{{ __('Edit Payment') }}</a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
