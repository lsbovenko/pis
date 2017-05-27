@extends('layouts.email')

@section('content')
    <p>
        Вы получили это письмо, потому что Вас пригласили принять участие в жизни компании Ikantam.
        Для завершения регистрации перейдите по
        <a href="{{route('invite', ['code' => $code])}}">ссылке</a>.
        Или скопируйте ссылку {{route('invite', ['code' => $code])}} и вставте в адресную строку браузера.
    </p>
@endsection
