@component('mail::message')
# {{ __('Event Registration Confirmed') }}

{{ __('Dear') }} {{ $user->name }},

{{ __('Your registration for') }} **{{ $event->title }}** {{ __('has been confirmed!') }}

## {{ __('Event Details') }}

**{{ __('Date') }}:** {{ $event->event_date->format('F j, Y') }}

@if($event->event_time)
**{{ __('Time') }}:** {{ $event->event_time->format('H:i') }}
@endif

@if($event->location)
**{{ __('Location') }}:** {{ $event->location }}
@endif

@if($event->description)
## {{ __('About This Event') }}

{{ Str::limit($event->description, 300) }}
@endif

@component('mail::button', ['url' => route('events.show', $event)])
{{ __('View Event Details') }}
@endcomponent

{{ __('We look forward to seeing you there!') }}

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
