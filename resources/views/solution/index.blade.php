@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            <h1 class="solution-title">Sprendimai</h1>
            @if(!$solutions->isEmpty())
                <div class="solution-overflow">
                    <table class="solution-table">
                        <tr>
                            @if(isset($sender) && $sender)
                                <th>Siuntėjas</th>
                            @else
                                <th>Gavėjas</th>
                            @endif
                            <th>Pavadinimas</th>
                            <th>Sprendimo data</th>
                            <th>Nuoroda</th>
                        </tr>
                        @foreach($solutions as $solution)
                            <tr>
                                @if(isset($sender) && $sender)
                                    <td>{{$solution->test->user->email}}
                                @else
                                    <td>{{$solution->user->email}}</td>
                                @endif
                                <td>{{$solution->test->title}}</td>
                                <td>{{$solution->created_at}}</td>
                                <td>
                                    <a href="{{route('solution.show', ['id' => $solution->id])}}">
                                        Peržiūrėti
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="text-center">Šis testas dar neturi jokių sprendimų</div>
            @endif
        </div>
    </div>
@endsection
