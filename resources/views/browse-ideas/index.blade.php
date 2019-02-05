@extends('layouts.app')

@section('scripts')
<script src="{{ mix('js/app.js') }}?v={{ config('app.version') }}"></script>
@stop