@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            <h1 class="solution-title">{{__('solutions.solutions')}}</h1>
            @if(!$solutions->isEmpty())
                <div class="solution-overflow">
                    <table class="solution-table">
                        <tr>
                            @if(isset($sender) && $sender)
                                <th>{{__('solutions.sender')}}</th>
                            @else
                                <th>{{__('solutions.receiver')}}</th>
                            @endif
                            <th>{{__('solutions.title')}}</th>
                            @if(isset($sender) && $sender)
                                <th>{{ucfirst(__('solutions.attempt'))}}</th>
                            @endif
                            <th>{{__('solutions.date')}}</th>
                            <th>{{__('solutions.link')}}</th>
                        </tr>
                        @foreach($solutions as $solution)
                            <tr>
                                @if(isset($sender) && $sender)
                                    <td>{{$solution->test->user->email}}
                                @else
                                    <td>{{$solution->user->email}}</td>
                                @endif

                                <td>{{Str::limit($solution->test->title, 20 , '...')}}</td>
                                @if(isset($sender) && $sender)
                                    <td>{{array_search($solution->created_at, $attempts[$solution->test_id])+1}}</td>
                                @endif
                                <td>{{$solution->created_at}}</td>
                                <td>
                                    <a href="{{route('solution.show', ['id' => $solution->id])}}">
                                        {{__('solutions.view')}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                {{ $solutions->links() }}
            @else
                <div class="text-center">{{__('solutions.noSolutions')}}</div>
            @endif
        </div>
    </div>
@endsection
