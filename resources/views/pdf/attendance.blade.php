<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 4px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>{{ $class->name }} – Attendance Report</h2>

<table>
    <thead>
        <tr>
            <th>Student</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>

        @foreach($students as $student)
            @if(isset($attendance[$student->id]))
                @foreach($attendance[$student->id] as $att)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $att->date }}</td>
                    <td>{{ ucfirst($att->status) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>–</td>
                    <td>–</td>
                </tr>
            @endif
        @endforeach

    </tbody>
</table>

</body>
</html>
