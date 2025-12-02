@php
    use Illuminate\Support\Str;
    use function Statamic\trans as __;
@endphp

@extends('statamic::layout')
@section('title', __('Healthchecks'))

@section('content')
    <div class="vhc-healthchecks">
        <header class="vhc-header mb-6">
            @include('statamic::partials.breadcrumb', [
                'url' => cp_route('utilities.index'),
                'title' => __('Utilities'),
            ])

            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="mb-1">{{ __('Health Checks') }}</h1>
                    <p class="text-sm text-gray dark:text-dark-150">
                        {{ __('View the health of your Statamic website. Need notifications? Integrate these with ') }}<a
                            href="https://govigilant.io">Vigilant!</a></p>
                </div>

                <a class="btn" href="{{ cp_route('utilities.vigilant-healthchecks') }}">
                    {{ __('Refresh') }}
                </a>
            </div>
        </header>

        <div class="card p-0 mb-6">
            <div class="p-4 border-b dark:border-dark-900">
                <h2 class="font-bold">{{ __('Checks') }}</h2>
            </div>

            <div class="p-4">
                @if (count($checks))
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">{{ __('Check') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="ltr:text-left rtl:text-right">{{ __('Message') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checks as $check)
                                @php
                                    $statusValue = $check['status'] ?? 'unknown';

                                    if ($statusValue instanceof \UnitEnum) {
                                        $statusValue =
                                            $statusValue instanceof \BackedEnum
                                                ? $statusValue->value
                                                : $statusValue->name;
                                    } elseif (!is_string($statusValue)) {
                                        $statusValue = is_scalar($statusValue) ? (string) $statusValue : 'unknown';
                                    }

                                    $statusModifier = Str::slug($statusValue);
                                    $statusModifier = in_array($statusModifier, ['healthy', 'warning', 'unhealthy'])
                                        ? $statusModifier
                                        : 'unknown';
                                    $statusLabel = Str::headline($statusModifier);
                                @endphp
                                <tr class="vhc-row vhc-row--{{ $statusModifier }}">
                                    <td>
                                        <span
                                            class="font-medium">{{ Str::headline($check['type'] ?? __('Unknown')) }}</span>
                                        @if (!empty($check['key']))
                                            <div class="text-xs text-gray dark:text-dark-150 mt-1">{{ $check['key'] }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge-pill vhc-badge vhc-badge--{{ $statusModifier }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-sm">
                                        {{ $check['message'] ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-sm text-gray dark:text-dark-150">{{ __('No health checks are currently registered.') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="card p-0">
            <div class="p-4 border-b dark:border-dark-900">
                <h2 class="font-bold">{{ __('Metrics') }}</h2>
            </div>

            <div class="p-4">
                @if (count($metrics))
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">{{ __('Metric') }}</th>
                                <th>{{ __('Value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($metrics as $metric)
                                <tr>
                                    <td>
                                        <span
                                            class="font-medium">{{ Str::headline($metric['type'] ?? __('Unknown')) }}</span>
                                    </td>
                                    <td>
                                        <span class="font-mono">
                                            {{ $metric['value'] ?? '—' }}
                                            @if (!empty($metric['unit']))
                                                <span
                                                    class="text-xs uppercase tracking-wide text-gray dark:text-dark-150">{{ $metric['unit'] }}</span>
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-sm text-gray dark:text-dark-150">{{ __('No metrics are currently registered.') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
