@component('mail::message')
# {{ __('messages.New Event Submission Received') }}

{{ __('messages.A new submission has been received for') }} **{{ $event->title }}**.

## {{ __('messages.Submission Details') }}

**{{ __('messages.Title') }}:** {{ $submission->title }}

**{{ __('messages.Submitted By') }}:** {{ $submitter->name }} ({{ $submitter->email }})

**{{ __('messages.Submission Type') }}:** {{ ucfirst($submission->submission_type) }}

**{{ __('messages.Abstract') }}:**
{{ Str::limit($submission->abstract, 200) }}

@if($submission->authors)
**{{ __('messages.Authors') }}:** {{ $submission->authors }}
@endif

@component('mail::button', ['url' => route('events.show', $event)])
{{ __('messages.View Event') }}
@endcomponent

{{ __('messages.Please review this submission and take appropriate action.') }}

{{ __('messages.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
