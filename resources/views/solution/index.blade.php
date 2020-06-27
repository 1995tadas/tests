@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            @if(!$solutions->isEmpty())
                <table class="solution-table">
                    <tr>
                        <th>Vartotojas</th>
                        <th>Sprendimo data</th>
                        <th>Rezultatas</th>
                    </tr>
                    @foreach($solutions as $solution)
                        <tr>
                            <td>{{$solution->user->email}}</td>
                            <td>{{$solution->created_at}}</td>
                            <td>
                                <a href="{{route('solution.show', ['id' => $solution->id])}}">
                                    Peržiūrėti
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="text-center">Šis testas dar neturi jokių sprendimų</div>
            @endif
        </div>
    </div>
@endsection
