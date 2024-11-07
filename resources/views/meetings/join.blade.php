@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Join Meeting</h1>
    <div id="zmmtg-root"></div>

    <script src="https://source.zoom.us/3.9.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.9.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.9.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.9.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.9.0/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-3.9.0.min.js"></script>
    
    <script>
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareWebSDK();
    
        var authEndpoint = '/meeting/signature'; // Laravel endpoint for signature
        var sdkKey = 'TmuEla_jRR2Hbq6fz4jA';
        var meetingNumber = '{{ $meeting->meeting_id }}';
        var passWord = '{{ $meeting->password }}'; // If meeting requires a password
        var role = '{{ $meeting->role }}'; // 0 for attendee, 1 for host
        var userName = '{{ Auth::user()->name }}';
        var userEmail = '{{ Auth::user()->email }}';
        var registrantToken = '';
        var zakToken = '';
        var leaveUrl = '{{ url('/home') }}';
    
        function getSignature() {
            fetch(authEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                },
                body: JSON.stringify({
                    meetingNumber: meetingNumber, // This should match the meeting ID
                    role: role // This should be either 0 or 1
                })
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then((data) => {
                if (data.error) {
                    console.error('Error fetching signature:', data.error);
                } else {
                    console.log(data);
                    startMeeting(data.signature);
                }
            })
            .catch((error) => {
                console.error('Error fetching signature:', error);
            });
        }

    
        function startMeeting(signature) {
            document.getElementById('zmmtg-root').style.display = 'block';

            ZoomMtg.init({
                leaveUrl: leaveUrl,
                patchJsMedia: true,
                leaveOnPageUnload: true,
                success: (success) => {
                    console.log(success);
                    ZoomMtg.join({
                        signature: signature,
                        sdkKey: sdkKey,
                        meetingNumber: meetingNumber,
                        passWord: passWord,
                        userName: userName,
                        userEmail: userEmail,
                        tk: registrantToken,
                        zak: zakToken,
                        success: (success) => {
                            console.log("Joined meeting successfully", success);
                        },
                        error: (error) => {
                            console.log("Error joining meeting", error);
                        },
                    });
                },
                error: (error) => {
                    console.log("Init error", error);
                }
            });
        }

    
        getSignature(); // Fetch signature and start meeting
    </script>
    
</div>
@endsection
