<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Activity Due Date Reminder</title>
</head>
<body>
    <p>Hello {{ $student->name }},</p>

    <p>This is a reminder that the activity <strong>{{ $activity->name }}</strong> in class <strong>{{ $class->name }}</strong> is due on <strong>{{ $activity->due_date->format('F j, Y') }}</strong>.</p>

    <p>Please submit your activity before the deadline.</p>

    <p>Thank you!</p>
</body>
</html>
