<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Öğretmen verdiği dersleri, öğrenci kayıtlı olduğu dersleri görür
        $courses = $user->isTeacher()
            ? $user->taughtCourses()->withCount(['students', 'materials'])->get()
            : $user->enrolledCourses()->with('teacher')->withCount('materials')->get();

        // Genel duyurular + kullanıcının derslerine ait duyurular
        $announcements = Announcement::with(['author', 'course'])
            ->where(fn ($query) => $query
                ->whereNull('course_id')
                ->orWhereIn('course_id', $courses->pluck('id')))
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('user', 'courses', 'announcements'));
    }
}