@component('mail::message')
# {{ __('messages.Event Registration Confirmed') }}

{{ __('messages.Dear') }} {{ $user->name }},

{{ __('messages.Your registration for') }} **{{ $event->title }}** {{ __('messages.has been confirmed!') }}

## {{ __('messages.Event Details') }}

**{{ __('messages.Date') }}:** {{ $event->event_date->format('F j, Y') }}

@if($event->event_time)
**{{ __('messages.Time') }}:** {{ $event->event_time->format('H:i') }}
@endif

@if($event->location)
**{{ __('messages.Location') }}:** {{ $event->location }}
@endif

@if($event->description)
## {{ __('messages.About This Event') }}

{{ Str::limit($event->description, 300) }}
@endif

@component('mail::button', ['url' => route('events.show', $event)])
{{ __('messages.View Event Details') }}
@endcomponent

{{ __('messages.We look forward to seeing you there!') }}

{{ __('messages.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
