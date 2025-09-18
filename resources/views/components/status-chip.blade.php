@props([
    'status' => '',
    'size' => 'default',
    'variant' => 'flat',
    'closable' => false
])

@php
    $statusConfig = [
        'active' => ['color' => 'success', 'icon' => 'mdi-check-circle', 'text' => __('Active')],
        'inactive' => ['color' => 'grey', 'icon' => 'mdi-pause-circle', 'text' => __('Inactive')],
        'pending' => ['color' => 'warning', 'icon' => 'mdi-clock', 'text' => __('Pending')],
        'completed' => ['color' => 'success', 'icon' => 'mdi-check', 'text' => __('Completed')],
        'cancelled' => ['color' => 'error', 'icon' => 'mdi-cancel', 'text' => __('Cancelled')],
        'suspended' => ['color' => 'orange', 'icon' => 'mdi-pause', 'text' => __('Suspended')],
        'draft' => ['color' => 'grey', 'icon' => 'mdi-file-outline', 'text' => __('Draft')],
        'published' => ['color' => 'success', 'icon' => 'mdi-publish', 'text' => __('Published')],
        'submitted' => ['color' => 'info', 'icon' => 'mdi-send', 'text' => __('Submitted')],
        'archived' => ['color' => 'grey-darken-2', 'icon' => 'mdi-archive', 'text' => __('Archived')],
        'approved' => ['color' => 'success', 'icon' => 'mdi-check-circle', 'text' => __('Approved')],
        'rejected' => ['color' => 'error', 'icon' => 'mdi-close-circle', 'text' => __('Rejected')],
        'available' => ['color' => 'success', 'icon' => 'mdi-check', 'text' => __('Available')],
        'reserved' => ['color' => 'warning', 'icon' => 'mdi-calendar-clock', 'text' => __('Reserved')],
        'maintenance' => ['color' => 'orange', 'icon' => 'mdi-tools', 'text' => __('Maintenance')],
        'out_of_order' => ['color' => 'error', 'icon' => 'mdi-alert-circle', 'text' => __('Out of Order')],
        'out_of_service' => ['color' => 'error', 'icon' => 'mdi-close-circle-outline', 'text' => __('Out of Service')],
        'confirmed' => ['color' => 'success', 'icon' => 'mdi-check-circle', 'text' => __('Confirmed')],
        'open' => ['color' => 'success', 'icon' => 'mdi-door-open', 'text' => __('Open')],
        'closed' => ['color' => 'error', 'icon' => 'mdi-door-closed', 'text' => __('Closed')],
        'ongoing' => ['color' => 'info', 'icon' => 'mdi-play', 'text' => __('Ongoing')],
        'article' => ['color' => 'blue', 'icon' => 'mdi-file-document', 'text' => __('Article')],
        'conference' => ['color' => 'purple', 'icon' => 'mdi-presentation', 'text' => __('Conference')],
        'book' => ['color' => 'green', 'icon' => 'mdi-book', 'text' => __('Book')],
        'patent' => ['color' => 'orange', 'icon' => 'mdi-lightbulb', 'text' => __('Patent')],
        'thesis' => ['color' => 'indigo', 'icon' => 'mdi-school', 'text' => __('Thesis')],
        'poster' => ['color' => 'pink', 'icon' => 'mdi-image', 'text' => __('Poster')],
        'seminar' => ['color' => 'teal', 'icon' => 'mdi-presentation-play', 'text' => __('Seminar')],
        'workshop' => ['color' => 'amber', 'icon' => 'mdi-hammer-wrench', 'text' => __('Workshop')],
        'summer_school' => ['color' => 'light-green', 'icon' => 'mdi-school-outline', 'text' => __('Summer School')],
        'research' => ['color' => 'deep-purple', 'icon' => 'mdi-flask', 'text' => __('Research')],
        'academic' => ['color' => 'blue-grey', 'icon' => 'mdi-school', 'text' => __('Academic')],
        'commercial' => ['color' => 'green', 'icon' => 'mdi-currency-usd', 'text' => __('Commercial')],
        'government' => ['color' => 'red', 'icon' => 'mdi-bank', 'text' => __('Government')],
        'admin' => ['color' => 'red', 'icon' => 'mdi-shield-crown', 'text' => __('Admin')],
        'researcher' => ['color' => 'blue', 'icon' => 'mdi-flask', 'text' => __('Researcher')],
        'lab_manager' => ['color' => 'green', 'icon' => 'mdi-microscope', 'text' => __('Lab Manager')],
        'visitor' => ['color' => 'grey', 'icon' => 'mdi-account-eye', 'text' => __('Visitor')],
    ];

    $config = $statusConfig[$status] ?? [
        'color' => 'grey',
        'icon' => 'mdi-help',
        'text' => ucfirst($status)
    ];
@endphp

<v-chip
    :color="'{{ $config['color'] }}'"
    size="{{ $size }}"
    variant="{{ $variant }}"
    @if($closable) closable @endif
    {{ $attributes }}
>
    <template v-slot:prepend>
        <v-icon size="small">{{ $config['icon'] }}</v-icon>
    </template>
    {{ $config['text'] }}
</v-chip>