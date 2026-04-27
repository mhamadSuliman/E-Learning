<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // حذف الكاش الخاص بالصلاحيات (اختياري بس مفيد)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الصلاحيات
        Permission::firstOrCreate(['name' => 'create course']);
        Permission::firstOrCreate(['name' => 'update course']);
        Permission::firstOrCreate(['name' => 'delete course']);
        Permission::firstOrCreate(['name' => 'view students']);
        Permission::firstOrCreate(['name' => 'view student reports']);
        Permission::firstOrCreate(['name' => 'manage courses']);


        // إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $instructorRole = Role::firstOrCreate(['name' => 'instructor']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // ربط الصلاحيات بالأدوار
        $adminRole->givePermissionTo([
            'manage courses',
            'view students',
            'delete course',
            'create course',
            'update course',
            'delete course',
            'view student reports'
            ]);
        $instructorRole->givePermissionTo([
        'manage courses',
        'create course',
        'view students',
        'update course',
        'delete course',
        'view student reports'
    ]);
        $studentRole->givePermissionTo([]);

      
    }
}
