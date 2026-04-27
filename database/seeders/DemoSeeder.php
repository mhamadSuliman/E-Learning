<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Courses_Categories;
use App\Models\Course;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run()
    {
  
      // 🔹 إنشاء المستخدمين
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        $instructor = User::firstOrCreate(
            ['email' => 'ahmad@example.com'],
            [
                'name' => 'Ahmad Instructor',
                'password' => Hash::make('password123'),
            ]
        );
        $instructor->assignRole('instructor');


        $instructor2 = User::firstOrCreate([
    'name' => 'New Instructor',
    'email' => 'teacher2@example.com',
    'password' => Hash::make('password123'),
]);

$instructor2->assignRole('instructor');

        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password123'),
            ]
        );
        $student->assignRole('student');

        // 🔹 إنشاء بعض التصنيفات
        $cat1 = Courses_Categories::firstOrCreate(['title' => 'Web Development']);
        $cat2 = Courses_Categories::firstOrCreate(['title' => 'Data Science']);
        $cat3 = Courses_Categories::firstOrCreate(['title' => 'Design']);

        // 🔹 إنشاء كورسات وربطها بالتصنيف والاستاذ
        $course1 = Course::firstOrCreate(
            ['title' => 'Laravel for Beginners'],
            [
                'description' => 'Learn Laravel from scratch.',
                'price' => 99.99,
                'author' => 'Ahmad Instructor',
                'duration' => 10,
                'category_id' => $cat1->id,
                'instructor_id' => $instructor->id,
            ]
        );

        $course2 = Course::firstOrCreate(
            ['title' => 'Advanced Data Analysis'],
            [
                'description' => 'Deep dive into data analysis.',
                'price' => 149.99,
                'author' => 'Ahmad Instructor',
                'duration' => 15,
                'category_id' => $cat2->id,
                'instructor_id' => $instructor->id,
            ]
        );

        // 🔹 تسجيل الطالب بالكورسات
        $student->enrolledCourses()->syncWithoutDetaching([$course1->id, $course2->id]);
    }
}
