@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            @if(!$solutions->isEmpty())
                <div class="solution-overflow">
                    <table class="solution-table">
                        <tr>
                            @if($solutions->first()->user_id === Auth::user()->id)
                                <th>Siuntėjas</th>
                            @else
                                <th>Gavėjas</th>
                            @endif
                            <th>Sprendimo data</th>
                            <th>Nuoroda</th>
                        </tr>
                        @foreach($solutions as $solution)
                            <tr>
                                @if($solutions->first()->user_id === Auth::user()->id)
                                    {{--                                    <td>{{dd($solution->sender)}}--}}
                                    <td>{{$solution->test->user->email}}</td>
                                @else
                                    <td>{{$solution->user->email}}</td>
                                @endif
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
