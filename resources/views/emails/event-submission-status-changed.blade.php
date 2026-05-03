@component('mail::message')
# {{ __('messages.Submission Status Update') }}

{{ __('messages.Your submission for') }} **{{ $event->title }}** {{ __('messages.has been updated') }}.

## {{ __('messages.Submission Details') }}

**{{ __('messages.Title') }}:** {{ $submission->title }}

**{{ __('messages.Previous Status') }}:** {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}

**{{ __('messages.New Status') }}:** {{ ucfirst(str_replace('_', ' ', $newStatus)) }}

@if($submission->reviewer_notes)
## {{ __('messages.Reviewer Notes') }}

{{ $submission->reviewer_notes }}
@endif

@if($newStatus === 'accepted')
@component('mail::panel')
🎉 **{{ __('messages.Congratulations!') }}** {{ __('messages.Your submission has been accepted.') }}
@endcomponent
@elseif($newStatus === 'rejected')
@component('mail::panel')
{{ __('messages.Unfortunately, your submission has not been accepted at this time.') }}
@endcomponent
@elseif($newStatus === 'revision_requested')
@component('mail::panel')
{{ __('messages.Please review the feedback and submit a revised version.') }}
@endcomponent
@endif

@component('mail::button', ['url' => route('events.show', $event)])
{{ __('messages.View Event') }}
@endcomponent

{{ __('messages.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
