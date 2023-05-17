<!DOCTYPE html>
<html>
<head>
    <title>test</title>
</head>
<body>
    <h1>test</h1>
    @foreach($questions as $question)
    <p>{{ $question['title'] }}</p>
    @endforeach
</body>
</html>
