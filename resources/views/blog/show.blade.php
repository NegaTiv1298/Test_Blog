@extends('layouts.app')
@section('title', 'Головна сторінка')
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

        <form method="post" action="{{ route('sort.post') }}">
            @csrf
            <select class="form-select" aria-label="Default select example" name="sort">
                <option value="created_at">Сортувати по даті створення</option>
                <option value="name">Сортувати по імені</option>
                <option value="email">Сортувати по емейлу</option>
            </select>
            <button type="submit" name="sort_submit" class="btn btn-primary">Сортувати</button>
        </form>
        <br>

        @foreach($info as $elem)

            <div class="comment_info" align="center">

                <p><b>Ім'я:</b> {{$elem->name}}</p>
                <p><b>E-mail:</b> {{$elem->email}}</p>
                <p><b>Текст:</b> {{$elem->text}}</p>
                @if(!empty($elem->image))
                    <p><img class="img-fluid" src="{{ asset('image/'. $elem->image) }}"/></p>
                @endif
                <p><b>Дата створення:</b> {{$elem->created_at}}</p>


                @if($elem->admin_edit == 1)
                    <span class="badge bg-info text-dark">Змінений адміністратором</span><br>
                @endif

                @if(!Auth::guest())
                    @if(Auth::user()->role == 'admin')
                        <a href="card/{{$elem->id}}" class="link-primary">Редагувати</a><br>
                    @endif
                @endif
                <br>
            </div>

        @endforeach

        {{$info->links()}}

        <form method="post" action="{{ route('blog.post') }}" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" @if(!Auth::guest()) value="{{Auth::user()->name}}"
                           @endif class="form-control" placeholder="Ім'я" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" @if(!Auth::guest()) value="{{Auth::user()->email}}"
                           @endif class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Текст</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
                <button type="submit" name="save_submit" class="btn btn-primary">Відправити</button>
            </div>
        </form>
    </div>
@stop
