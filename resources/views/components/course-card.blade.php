{{--
    Ders kartı. Kullanım:
    <x-course-card :course="$course" />                    (öğrenci: öğretmen adını gösterir)
    <x-course-card :course="$course" :for-teacher="true" /> (öğretmen: öğrenci sayısını gösterir)
--}}
@props(['course', 'forTeacher' => false])

@php
    // Tailwind sınıfları tam yazılmalı: "bg-{{ $course->color }}" gibi parça parça
    // yazılırsa Tailwind bu sınıfları bulamaz ve CSS'e eklemez.
    $colors = [
        'lavender' => 'bg-lavender',
        'mint' => 'bg-mint',
        'peach' => 'bg-peach',
        'sky' => 'bg-sky',
        'rose' => 'bg-rose',
    ];
    $bg = $colors[$course->color] ?? 'bg-lavender';
@endphp

<article {{ $attributes->class([
    'flex flex-col gap-4 rounded-2xl p-5 text-ink shadow-sm ring-1 ring-plum/5 transition hover:-translate-y-0.5 hover:shadow-md',
    $bg,
]) }}>
    <div class="flex items-start justify-between gap-3">
        <h3 class="font-serif text-xl leading-snug">{{ $course->title }}</h3>
        <flux:icon.book-open-text class="size-5 shrink-0 text-plum/60" />
    </div>

    @if ($course->description)
        <p class="text-sm text-ink/70">{{ $course->description }}</p>
    @endif

    <div class="mt-auto flex flex-wrap items-center gap-2 text-xs font-medium">
        @if ($forTeacher)
            <span class="rounded-full bg-white/60 px-3 py-1">{{ $course->students_count }} {{ __('students') }}</span>
        @else
            <span class="rounded-full bg-white/60 px-3 py-1">{{ $course->teacher->name }}</span>
        @endif

        <span class="rounded-full bg-white/60 px-3 py-1">{{ $course->materials_count }} {{ __('resources') }}</span>
    </div>
</article>
