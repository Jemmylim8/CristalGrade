<!DOCTYPE html>
<html>
<head>
    <style>
    body { 
        font-family: sans-serif; 
        font-size: 11px;
    }

    table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 20px; 
        table-layout: fixed; /* prevents overlap */
    }

    th, td { 
        border: 1px solid black; 
        padding: 4px; 
        text-align: center; 
        word-wrap: break-word; 
        font-size: 10px;
    }

    th { 
        background: #eee; 
    }

    thead {
        display: table-header-group; /* repeat header every page */
    }

    tr { 
        page-break-inside: avoid; 
    }
</style>

</head>
<body>

<h2>{{ $class->name }} – Scores Report</h2>

<table>
    <thead>
        <tr>
            <th>Student</th>
            @foreach($activities as $activity)
                <th>{{ $activity->name }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            @foreach($activities as $activity)
                <td>
                {{ $activity->scores->where('student_id', $student->id)->first()->score ?? '-' }}
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
