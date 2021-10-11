@extends('layouts.app')
@section('title', 'Адміністратор')
@section('content')
    <div class="container">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif
        @foreach($info as $elem)
            <div class="border border-dark rounded" align="center">

                <form method="post" action="{{ route('approved.comment', $elem->id) }}">
                    @csrf
                    @method('PUT')
                    <p><b>Ім'я:</b> {{$elem->name}}</p>
                    <p><b>E-mail:</b> {{$elem->email}}</p>
                    <p><b>Текст:</b> {{$elem->text}}</p>
                    <p><b>Дата створення:</b> {{$elem->created_at}}</p>

                    <a class="nav-link" aria-current="page" href="card/{{$elem->id}}">Редагувати</a>
                    @if($elem->approved == 1)
                        <span class="badge bg-success">Перевірено адміністратором</span><br>
                    @else
                        <button type="submit" class="btn btn-success" name="approved_comment">Прийняти</button>
                        <span class="badge bg-danger">Не перевірено адміністратором</span><br>
                    @endif

                    @if(!Auth::guest())
                        @if(Auth::user()->role == 'admin')
                            <a href="card/{{$elem->id}}" class="link-primary">Редагувати</a><br>
                        @endif
                    @endif
                    <br>
                </form>
            </div>
    @endforeach
@stop
