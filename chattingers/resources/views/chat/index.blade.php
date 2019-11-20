@extends('layouts.index')

@section('user-list')


    <div class="row">
            
        <div class="col-sm-4">
            <ul class="list-group list-group-flush mt-5">
            @foreach ($user as $item => $user)
                <li class="list-group-item text-black">
                    {{$user['name']}}
                    
                <a href="/demo/chat/{{$id}}{{$user['id']}}" class="btn btn-primary">Pesan</a>
                </li>
            @endforeach
            </ul>
        </div>
        <div class="col-sm-8">
            
            </div>
            
        </div>
        
    </div>
@endsection