@extends('includes.main')

@section('title')
    {{ __('Project Position') }}
@endsection

@section('sidebar')
    @auth
      @include('includes.sidebar')
  @endauth
@endsection

@section('content')
<input type="hidden" id="project-id" value="{{ $project->id }}">
<div class="content-wrapper container-fluid">
  <form class="filter-form">
    <div class="row">
      <div class="col-lg-12 form-inline m-2">
          <div class="input-group">
              <button type="button" class="btn btn-primary refresh-position--button__popup"><i class="fas fa-sync"></i></button>
          </div>
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text" for="filter_search_engine">{{ __('Search Engine') }}: </label>
            </div>
            <select id="filter_search_engine" class="form-control selectbox__small search-engine-filter--selectbox" name="filter_search_engine">
              <option value="yandex" {{('yandex' == $filters['values']['search_engine'] || $filters['values']['search_engine'] == '') ? 'selected' : ''}}>{{ __('Yandex') }}</option>
              <option value="google" {{'google' == $filters['values']['search_engine'] ? 'selected' : ''}}>{{ __('Google') }}</option>
            </select>
          </div>
          @if(count($filters['regions'])  > 0)
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text" for="filter_region_id">{{ __('Region') }}: </label>
            </div>
            <select id="filter_region_id" class="form-control selectbox__small" name="filter_region_id">
              @foreach ($filters['regions'] as $filterRegion)
                <option value="{{ $filterRegion->id }}" {{$filterRegion->id == $filters['values']['region_id']  ? 'selected' : ''}}>{{ $filterRegion->name }}</option>
              @endforeach
            </select>
          </div>
          @endif

          <div class="input-group">
            <div class="input-group-prepend">
              <label class="input-group-text" for="filter_query_group_id">{{ __('Query Groups') }}: </label>
            </div>
            <select id="filter_query_group_id" class="form-control selectbox__small" name="filter_query_group_id">
              <option value="">{{ __('All Groups') }}</option>
              @foreach ($filters['query_groups'] as $queryGroup)
                <option value="{{ $queryGroup['id'] }}" {{$queryGroup['id'] == $filters['values']['query_group_id']  ? 'selected' : ''}}>@php echo str_repeat('&nbsp;', $queryGroup['level']); @endphp {{ $queryGroup['name'] }}</option>
              @endforeach
            </select>
          </div>

          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon3">{{ __('Date') }}: </span>
            </div>
            <input type="text" class="form-control datepicker" value="{{ $filters['values']['start_date']  }}" name="filter_start_date">
            <input type="text" class="form-control datepicker" value="{{ $filters['values']['end_date']  }}" name="filter_end_date">
          </div>

          <div class="input-group">
            <input type="submit" class="btn btn-primary" value="{{ __('OK') }}"/>
          </div>

      </div>
    </div>
  </form>

  <div class="row mt-5">
      <div class="col-lg-8">
        <h1><span class="badge badge-secondary">{{ $project->name }}</span></h1>
        <h2><span class="badge badge-secondary">{{ $project->url }}</span></h2>
        <h3><span class="loading-icon-container d-none"><i class="fas fa-sync"></i></span></h3>



{{--          <label for="filter_query_group_id">{{ __('Query Groups') }}: </label>--}}
{{--            <ul class="list-group query-group-setup list-group-sm">--}}
{{--                <li class="list-group-item bg-info list-group-item-main">--}}
{{--                    <div class="d-flex w-100 justify-content-between">--}}
{{--                      <span>{{ __('All Query Groups') }}</span>--}}
{{--                      <div class="custom-control custom-switch yandex-switch">--}}
{{--                        <input type="checkbox" name="yandex-search" class="custom-control-input" id="yandexSwitch" checked="checked">--}}
{{--                        <label class="custom-control-label" for="yandexSwitch"></label>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  </li>--}}
{{--                @foreach ($filters['query_groups'] as $queryGroup)--}}
{{--                <li class="list-group-item region--list">--}}
{{--                <div class="d-flex w-100 justify-content-between">--}}
{{--                  <span>@php echo str_repeat('&nbsp;', $queryGroup['level']); @endphp {{ $queryGroup['name'] }}</span>--}}
{{--                  <div class="custom-control custom-switch">--}}
{{--                    <input type="checkbox" name="[yandex][{{ $queryGroup['id'] }}]" data-region-id="{{ $queryGroup['id'] }}" class="custom-control-input" id="yandexSwitch_{{ $queryGroup['id'] }}" checked="checked">--}}
{{--                    <label class="custom-control-label" for="yandexSwitch_{{ $queryGroup['id'] }}"></label>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
      </div>
    </div>

    <div class="col-lg-12 position-table-container mt-4">

      @if(count($positions)  < 1)
        <div class="alert alert-dark" role="alert">
          {{ __('No Positions') }}
        </div>
      @else
      <table class="table  table-sm">
        <thead class="thead-dark">
          <tr>
            <th scope="col">{{__('Queries')}} ({{$queries->count()}})</th>
            @foreach ($dates as $date)
            <th scope="col">{{ \Carbon\Carbon::parse($date->action_date)->format('d.m.Y') }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($queries as $query)
          <tr data-query-id="{{ $query->query_id }}" class="">
            <td>{{ $query->query_name }} </td>
            @foreach ($dates as $date)
            @php ($positionKey = $query->query_id . '--' . $date->action_date)
            <td>
              @if(isset($positions[$positionKey]))
                @if(isset($positions[$positionKey]['yandex']))
                    @foreach ($positions[$positionKey]['yandex'] as $yandex)
                        <div class="yandex-position-container {{ $yandex['position_class_name'] }}">
                            {{ $yandex['position'] > 0 ? $yandex['position'] : '--' }}
                        </div>
                    @endforeach
                @endif
                @if(isset($positions[$positionKey]['google']))
                      @foreach ($positions[$positionKey]['google'] as $google)
                    <div class="google-position-container {{$google['position_class_name']}}">
                        {{ $google['position'] > 0 ? $google['position'] : '--' }}
                    </div>
                      @endforeach
                @endif
              @endif
            </td>
            @endforeach
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</div>
@endsection

@section('modal-section')
  @include('position.modal-content')
@endsection
