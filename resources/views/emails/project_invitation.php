<!DOCTYPE html>
<html>
<head>
    <title>Project Invitation</title>
</head>
<body>
    <h2>Project Invitation</h2>
    <p>Hi {{ $collaborator->name }},</p>
    <p>You have been invited to collaborate on the project: <strong>{{ $project->name }}</strong> by {{ $user->name }}</p>
    <p>To accept the invitation, click the link below:</p>
    <a href="{{ route('collaborations.accept', ['projectUser' => $project->users->where('user_id', $collaborator->id)->first()->id]) }}">Accept Invitation</a>
    <p>If you don't want to collaborate on this project, you can decline the invitation.</p>
    <a href="{{ route('collaborations.decline', ['projectUser' => $project->users->where('user_id', $collaborator->id)->first()->id]) }}">Decline Invitation</a>
    <p>Thanks,<br> {{ $user->name }}</p>
</body>
</html>