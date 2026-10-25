@php
    $status = strtolower((string) ($status ?? ''));
    $variant = match (true) {
        in_array($status, ['hired', 'accepted', 'passed', 'pass', 'approved', 'active', 'completed', 'ok', 'open']) => 'success',
        in_array($status, ['rejected', 'failed', 'fail', 'declined', 'expired', 'cancelled', 'canceled', 'suspended', 'removed']) => 'error',
        in_array($status, ['withdrawn', 'draft', 'closed', 'archived', '']) => 'neutral',
        in_array($status, ['offer', 'sent', 'pending', 'screening', 'shortlisted', 'in_progress', 'booked', 'scheduled']) => 'pending',
        default => 'info',
    };
@endphp
<x-badge :variant="$variant" :dot="true">{{ $status === '' ? '—' : \Illuminate\Support\Str::headline($status) }}</x-badge>
