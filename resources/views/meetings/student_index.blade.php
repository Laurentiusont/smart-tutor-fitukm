@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Meetings</h1>
    
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if($meetings->isEmpty())
        <div class="alert alert-info">There are no meetings scheduled at the moment.</div>
    @else
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
                        <td>{{ \Carbon\Carbon::parse($meeting->start_time)->format('Y-m-d H:i') }}</td>
                        <td><a href="{{ $meeting->join_url }}" target="_blank">Join Meeting</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
