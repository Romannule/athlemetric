@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Associations</h1>
        @if (count($associations) > 0)
            <ul class="list-group">
                @foreach ($associations as $association)
                    <li class="list-group-item">{{ $association->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No associations found</p>
        @endif
    </div>
@endsection