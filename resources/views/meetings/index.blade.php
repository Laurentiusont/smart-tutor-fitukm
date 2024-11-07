@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Meetings</h1>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Topic</th>
                <th>Start Time</th>
                <th>Join URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->topic }}</td>
                    <td>{{ $meeting->start_time }}</td>
                    <td><a href="{{ $meeting->join_url }}" target="_blank">Join Meeting</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
