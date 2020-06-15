@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <form method="post" action="{{route("test.store")}}">
                @csrf
                <div class="form-group">
                    <label for="title">Testo pavadinimas</label>
                    <input class="form-control" type="text" id="title" name="title">
                    @error('title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Išsaugoti" >
                </div>
            </form>
        </div>
    </div>
@endsection
