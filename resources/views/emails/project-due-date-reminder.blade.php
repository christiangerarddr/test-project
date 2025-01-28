@component('mail::message')
    Your project is due in 24 hours.

    project_id: {{$project->id}}
    project_title: {{$project->title}}
    project_status: {{$project->status}}
    project_description: {{$project->description}}
@endcomponent

@component('mail::button', ['url' => url("/project/{$project->id}")])
    {{ __('Check Project') }}
@endcomponent
