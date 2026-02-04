@component('mail::message')
# {{ __('Publication Status Update') }}

{{ __('Your publication') }} **{{ $publication->title }}** {{ __('has been') }} **{{ $action }}**.

## {{ __('Publication Details') }}

**{{ __('Title') }}:** {{ $publication->title }}

**{{ __('Authors') }}:** {{ $publication->authors }}

**{{ __('Year') }}:** {{ $publication->year }}

**{{ __('Type') }}:** {{ ucfirst($publication->type) }}

@if($action === 'approved')
@component('mail::panel')
🎉 **{{ __('Congratulations!') }}** {{ __('Your publication has been approved and is now visible to the public.') }}
@endcomponent
@elseif($action === 'rejected')
@component('mail::panel')
{{ __('Your publication has been rejected. Please contact an administrator for more information.') }}
@endcomponent
@endif

@component('mail::button', ['url' => route('publications.show', $publication)])
{{ __('View Publication') }}
@endcomponent

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
