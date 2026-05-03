@component('mail::message')
# {{ __('messages.Publication Status Update') }}

{{ __('messages.Your publication') }} **{{ $publication->title }}** {{ __('messages.has been') }} **{{ $action }}**.

## {{ __('messages.Publication Details') }}

**{{ __('messages.Title') }}:** {{ $publication->title }}

**{{ __('messages.Authors') }}:** {{ $publication->authors }}

**{{ __('messages.Year') }}:** {{ $publication->year }}

**{{ __('messages.Type') }}:** {{ ucfirst($publication->type) }}

@if($action === 'approved')
@component('mail::panel')
🎉 **{{ __('messages.Congratulations!') }}** {{ __('messages.Your publication has been approved and is now visible to the public.') }}
@endcomponent
@elseif($action === 'rejected')
@component('mail::panel')
{{ __('messages.Your publication has been rejected. Please contact an administrator for more information.') }}
@endcomponent
@endif

@component('mail::button', ['url' => route('publications.show', $publication)])
{{ __('messages.View Publication') }}
@endcomponent

{{ __('messages.Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
