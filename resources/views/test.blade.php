<!DOCTYPE html>
<html>
<head>
    <title>test</title>
</head>
<body>
    <h1>test</h1>
    @foreach($questions as $question)
    <p><a href="{{ $question['url'] }}">{{ $question['title'] }}</a></p>
    @endforeach
</body>
</html>
