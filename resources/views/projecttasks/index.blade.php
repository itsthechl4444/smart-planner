<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Tasks</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Project Tasks</h2>
        <a href="{{ route('projecttasks.create') }}" class="btn waves-effect waves-light">Create Project Task</a>
        <table class="striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Label</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ $task->label->name ?? 'No Label' }}</td>
                        <td>
                            <a href="{{ route('projecttasks.show', $task->id) }}" class="btn-small blue">View</a>
                            <a href="{{ route('projecttasks.edit', $task->id) }}" class="btn-small orange">Edit</a>
                            <form action="{{ route('projecttasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-small red">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
