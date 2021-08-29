@extends('template')
@section('content')
@if ($category->count())
@foreach ($category as $c)
<div class="container-fluid link-wrapper">
  <div class="cat" title="{{ $c->description }}">{{ $c->name }}</div>
  <div class="container-fluid">
    <div class="row">
      @foreach ($c->links as $l)
      @if ($l->active)
      <div class="link">
        <a class="d-block" title="{{ $l->description }}" href="{{ $l->link_val }}">{{ $l->name }}</a>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</div>
@endforeach
@endif
@endsection