@extends('layouts.email')

@section('content')
    <p>
        {{ $comment->user->getFullName() }}
        {{ trans('ideas.new_comment') }} <a href="{{ route('review-idea', ['id' => $comment->idea->id]) }}">"{{ $comment->idea->title }}</a>".
    </p>
    <div>
        <?php
            echo str_replace(
                '<span class="js-mention">',
                '<span style="background-color: #c5deed; color: #1264a3; padding: 3px; border-radius: 10px;">',
                $comment->message
            );
        ?>
    </div>
@endsection
