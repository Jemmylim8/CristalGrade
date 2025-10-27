
<div class="container">
    <h1>Activities for {{ $class->name }}</h1>

    <a href="{{ route('activities.create', $class->id) }}" class="btn btn-primary mb-3">Add Activity</a>

    @if ($class->activities->isEmpty())
        <p>No activities yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Max Score</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($class->activities as $activity)
                    <tr>
                        <td>{{ $activity->title }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->max_score }}</td>
                        <td>{{ $activity->due_date }}</td>
                        <td>
                            <a href="{{ route('activities.scores', [$class->id, $activity->id]) }}" class="btn btn-sm btn-success">Enter Scores</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
