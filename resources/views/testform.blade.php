<!DOCTYPE html>
<html>
<head>
    <title>Test Mentorship Request</title>
</head>
<body>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/test-request">
        @csrf
        <label for="mentor_id">Mentor ID:</label><br>
        <input type="text" name="mentor_id" id="mentor_id" value="2"><br><br>

        <label for="message">Message:</label><br>
        <textarea name="message" id="message" rows="4" cols="40">Please guide me</textarea><br><br>

        <button type="submit">Send Request</button>
    </form>
</body>
</html>
