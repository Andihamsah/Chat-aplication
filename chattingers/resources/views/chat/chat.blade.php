@extends('layouts.index')

@section('user-list')
    <div class="row text-center mt-5">
        <div class="col-sm">
            
            
            
            @foreach ($receiver as $item2)
                <br>
        <p>{{$item2->text}}</p>
        <hr>
        <br>
        @endforeach
        @foreach ($sender as $items)
            <br>
        <p class="text-right">{{$items->text}}</p>
        <br>
        <hr>
        <br>
       
            @endforeach
    
        <form action="{{route('demoSendChat')}}" method="post">
            <input type="text" name="text" id="inputDisabledEx2" class="form-control" >
        <input type="hidden" name="sender_id" value="{{$sender_id}}">
        <input type="hidden" name="receiver_id" value="{{$receiver_id}}">
            <button type="submit" class="btn btn-primary">send</button>
        </form>
        </div>
    </div>
@endsection