@extends('layouts.app')
@section('title', 'Детальніше')
@section('content')

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @foreach($info as $elem)
        <form method="post" action="{{ route('edit.comment', $elem->id) }}">
            @csrf
            @method('PUT')
            <div class="form">
                <div class="mb-3">
                    <input type="text" name="id" class="form-control" value="ID {{$elem->id}}" disabled>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$elem->name}}" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" value="{{$elem->email}}" disabled>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Текст</label>
                    <input type="text" name="description" class="form-control" value="{{$elem->text}}">
                </div>
                <button type="submit" name="save_submit" class="btn btn-primary">Редагувати</button>
            </div>
        </form>
    @endforeach
@stop
