<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 öğretmen
        $teachers = collect([
            ['Elif Arslan', 'elif@tch.com'],
            ['Murat Koç', 'murat@tch.com'],
            ['Selin Aydın', 'selin@tch.com'],
            ['Burak Öztürk', 'burak@tch.com'],
            ['Deniz Yıldız', 'deniz@tch.com'],
        ])->map(fn ($t) => User::factory()->create([
            'name' => $t[0],
            'email' => $t[1],
            'role' => 'teacher',
            'password' => Hash::make('teacher123'),
        ]));

        // 5 öğrenci
        $students = collect([
            ['Ali Yılmaz', 'ali@stu.com'],
            ['Ayşe Kaya', 'ayse@stu.com'],
            ['Mehmet Demir', 'mehmet@stu.com'],
            ['Zeynep Çelik', 'zeynep@stu.com'],
            ['Can Şahin', 'can@stu.com'],
        ])->map(fn ($s) => User::factory()->create([
            'name' => $s[0],
            'email' => $s[1],
            'role' => 'student',
            'password' => Hash::make('student123'),
        ]));

        // Her öğretmene bir ders
        $courseData = [
            ['Web Development Fundamentals', 'HTML, CSS and JavaScript from the ground up.', 'lavender'],
            ['Database Design', 'Relational modeling, SQL and normalization.', 'mint'],
            ['UI/UX Design Principles', 'Designing interfaces people love to use.', 'peach'],
            ['Introduction to Algorithms', 'Sorting, searching and complexity analysis.', 'sky'],
            ['Mobile App Development', 'Building cross-platform mobile applications.', 'rose'],
        ];

        $courses = $teachers->map(function ($teacher, $i) use ($courseData) {
            [$title, $description, $color] = $courseData[$i];

            return Course::create([
                'teacher_id' => $teacher->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $description,
                'color' => $color,
            ]);
        });

        // Her öğrenciyi rastgele 3 derse kaydet
        foreach ($students as $student) {
            $student->enrolledCourses()->attach($courses->random(3)->pluck('id'));
        }

        // Her derse örnek kaynaklar ve bir duyuru
        foreach ($courses as $course) {
            Material::create([
                'course_id' => $course->id,
                'title' => 'Course Syllabus',
                'description' => 'Weekly topics, grading and important dates.',
                'type' => 'document',
            ]);
            Material::create([
                'course_id' => $course->id,
                'title' => 'Week 1 Lecture',
                'description' => 'Recorded introduction lecture.',
                'type' => 'video',
                'url' => 'https://example.com/lecture',
            ]);
            Material::create([
                'course_id' => $course->id,
                'title' => 'Further Reading',
                'description' => 'Recommended articles for this week.',
                'type' => 'link',
                'url' => 'https://example.com/reading',
            ]);

            Announcement::create([
                'user_id' => $course->teacher_id,
                'course_id' => $course->id,
                'body' => "Welcome to {$course->title}! Please review the syllabus before our first session.",
            ]);
        }

        // Ana sayfada görünecek genel duyurular
        Announcement::create([
            'user_id' => $teachers[0]->id,
            'body' => 'Welcome to BTlearning! The fall semester starts on Monday. 🎓',
        ]);
        Announcement::create([
            'user_id' => $teachers[1]->id,
            'body' => 'The library will be open until midnight during exam week. 📚',
        ]);
    }
}