@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper user-wrapper">
            <h1>Mano paskyra</h1>
            <ul class="stat">
                <li><span>Vardas: </span>{{$user->name}}</li>
                <li><span>El.paštas: </span>{{$user->email}}</li>
                <li><span>Reg.data: </span>{{$user->created_at}}</li>
                <li><span>Sukurti testai: </span>{{$testCount}}</li>
                <li><span>Išspresti testai: </span>{{$solutionCount}}</li>
            </ul>
        </div>
    </div>
@endsection
