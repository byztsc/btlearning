{{--
    Sohbet balonu şeklinde duyuru. Kullanım:
    <x-announcement-bubble :announcement="$announcement" />
    <x-announcement-bubble :announcement="$announcement" :mine="true" /> (kendi duyurun: sağda, mürdüm renkte)
--}}
@props(['announcement', 'mine' => false])

@php
    // Ders etiketinin rengi dersin rengiyle aynı olsun (ders kartındaki gibi tam sınıf adları)
    $colors = [
        'lavender' => 'bg-lavender',
        'mint' => 'bg-mint',
        'peach' => 'bg-peach',
        'sky' => 'bg-sky',
        'rose' => 'bg-rose',
    ];
    $tag = $announcement->course
        ? ($colors[$announcement->course->color] ?? 'bg-lavender')
        : 'bg-cream';
@endphp

<div {{ $attributes->class(['flex items-end gap-3', 'flex-row-reverse' => $mine]) }}>
    <flux:avatar size="sm" :name="$announcement->author->name" :initials="$announcement->author->initials()" />

    {{-- Bir köşesi sivri balon: konuşma "kuyruğu" avatara bakan köşede --}}
    <div @class([
        'max-w-md rounded-2xl px-4 py-3 shadow-sm',
        'rounded-bl-sm bg-white text-ink ring-1 ring-plum/10' => ! $mine,
        'rounded-br-sm bg-plum text-white' => $mine,
    ])>
        <div class="mb-1 flex flex-wrap items-center gap-2 text-xs">
            <span class="font-semibold">{{ $announcement->author->name }}</span>
            <span class="rounded-full px-2 py-0.5 text-ink {{ $tag }}">
                {{ $announcement->course?->title ?? __('General') }}
            </span>
        </div>

        <p class="text-sm leading-relaxed">{{ $announcement->body }}</p>

        <time
            datetime="{{ $announcement->created_at->toIso8601String() }}"
            @class(['mt-1 block text-[11px]', 'text-ink/50' => ! $mine, 'text-white/60' => $mine])
        >{{ $announcement->created_at->diffForHumans() }}</time>
    </div>
</div>
