@component('mail::message')
# {{ __('New Event Submission Received') }}

{{ __('A new submission has been received for') }} **{{ $event->title }}**.

## {{ __('Submission Details') }}

**{{ __('Title') }}:** {{ $submission->title }}

**{{ __('Submitted By') }}:** {{ $submitter->name }} ({{ $submitter->email }})

**{{ __('Submission Type') }}:** {{ ucfirst($submission->submission_type) }}

**{{ __('Abstract') }}:**
{{ Str::limit($submission->abstract, 200) }}

@if($submission->authors)
**{{ __('Authors') }}:** {{ $submission->authors }}
@endif

@component('mail::button', ['url' => route('events.show', $event)])
{{ __('View Event') }}
@endcomponent

{{ __('Please review this submission and take appropriate action.') }}

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
