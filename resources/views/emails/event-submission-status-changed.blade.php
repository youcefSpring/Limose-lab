@component('mail::message')
# {{ __('Submission Status Update') }}

{{ __('Your submission for') }} **{{ $event->title }}** {{ __('has been updated') }}.

## {{ __('Submission Details') }}

**{{ __('Title') }}:** {{ $submission->title }}

**{{ __('Previous Status') }}:** {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}

**{{ __('New Status') }}:** {{ ucfirst(str_replace('_', ' ', $newStatus)) }}

@if($submission->reviewer_notes)
## {{ __('Reviewer Notes') }}

{{ $submission->reviewer_notes }}
@endif

@if($newStatus === 'accepted')
@component('mail::panel')
🎉 **{{ __('Congratulations!') }}** {{ __('Your submission has been accepted.') }}
@endcomponent
@elseif($newStatus === 'rejected')
@component('mail::panel')
{{ __('Unfortunately, your submission has not been accepted at this time.') }}
@endcomponent
@elseif($newStatus === 'revision_requested')
@component('mail::panel')
{{ __('Please review the feedback and submit a revised version.') }}
@endcomponent
@endif

@component('mail::button', ['url' => route('events.show', $event)])
{{ __('View Event') }}
@endcomponent

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
