@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            <h1 class="solution-title">{{$test->title}}</h1>
            <div class="note flex-notes">
                <span><i style="color:#000" class="fas fa-check"></i> = {{__('solutions.correctAnswersNote')}}</span>
                <span><span class="incorrect-example"></span> - {{__('solutions.incorrectNote')}}</span>
                <span><span class="correct-example"></span> - {{__('solutions.correctNote')}}</span>
            </div>
            @foreach($paginatedResults as $questionId => $singleResult)
                @if(is_int($questionId))
                    <h4 class="text-center">{{$test->questionById($questionId)->content}}</h4>
                    <ul class="list-group my-2">
                        @foreach($test->questionById($questionId)->answers as $answer)
                            <li class="list-group-item
                            @if(isset($singleResult['answers'][$answer->number]))
                            @if($singleResult['answers'][$answer->number] === true)
                            {{'list-group-item-success'}}
                            @elseif($singleResult['answers'][$answer->number] === false)
                            {{'list-group-item-danger'}}
                            @endif
                            @endif">
                                {{$answer->content}}
                                @if(isset($singleResult['correct'][$answer->number]))
                                    <i class="fas fa-check"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="answer-verdict">
                        @if($singleResult['result'])
                            {{__('solutions.right')}}
                        @else
                            {{__('solutions.wrong')}}
                        @endif
                    </div>
                @endif
            @endforeach
            <div class="text-center">
                <div>{{__('solutions.final')}}:</div>
                <div>{{$final.'/'.$resultCount}}</div>
            </div>
            <div>
                {{ $paginatedResults->links() }}
            </div>
        </div>
    </div>
@endsection
