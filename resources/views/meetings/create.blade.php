@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Meeting</h1>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('meetings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="topic">Meeting Topic</label>
            <input type="text" name="topic" id="topic" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Meeting</button>
    </form>
</div>
@endsection
