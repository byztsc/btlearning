<x-layouts::app :title="__('Dashboard')">
    <div class="flex w-full flex-1 flex-col gap-8">

        {{-- Karşılama başlığı --}}
        <header>
            <p class="text-sm font-medium text-plum-soft">
                {{ $user->isTeacher() ? __('Teacher') : __('Student') }}
            </p>
            <h1 class="font-serif text-3xl text-ink dark:text-zinc-100">
                {{ __('Hello, :name', ['name' => $user->name]) }}
            </h1>
        </header>

        <div class="grid gap-8 lg:grid-cols-3">

            {{-- Sol taraf: dersler (geniş ekranda 3 sütunun 2'si) --}}
            <section class="lg:col-span-2">
                <h2 class="mb-4 font-serif text-xl text-plum dark:text-lavender">
                    {{ $user->isTeacher() ? __('Courses you teach') : __('Your courses') }}
                </h2>

                @if ($courses->isEmpty())
                    <p class="rounded-2xl bg-white/70 p-6 text-sm text-ink/60 ring-1 ring-plum/10">
                        {{ __('No courses yet.') }}
                    </p>
                @else
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($courses as $course)
                            <x-course-card :course="$course" :for-teacher="$user->isTeacher()" />
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- Sağ taraf: sohbet balonu şeklinde duyurular --}}
            <section>
                <h2 class="mb-4 font-serif text-xl text-plum dark:text-lavender">
                    {{ __('Announcements') }}
                </h2>

                @if ($announcements->isEmpty())
                    <p class="rounded-2xl bg-white/70 p-6 text-sm text-ink/60 ring-1 ring-plum/10">
                        {{ __('No announcements yet.') }}
                    </p>
                @else
                    <div class="flex flex-col gap-4">
                        @foreach ($announcements as $announcement)
                            <x-announcement-bubble
                                :announcement="$announcement"
                                :mine="$announcement->user_id === $user->id"
                            />
                        @endforeach
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-layouts::app>
