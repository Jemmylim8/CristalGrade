<!DOCTYPE html>
<html>
<head>
    <title>Attendance - {{ $class->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
        th { background-color: #f1f1f1; }
    </style>
</head>
<body>
    <h2>Class: {{ $class->name }} – {{ $class->subject }}</h2>
    <p>Schedule: {{ $class->schedule }}</p>

   <table class="table-auto border w-full">
    <thead>
        <tr>
            <th>Student</th>
            @foreach($attendances as $att)
                <th>{{ $att->date }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                @foreach($attendances as $att)
                    <td>{{ $records[$student->id][$att->id] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
