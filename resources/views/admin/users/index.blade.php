<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 p-4 sm:p-8">

        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-purple-700 via-violet-600 to-indigo-600 bg-clip-text text-transparent">
                        Users Management
                    </h1>
                    <p class="mt-1 text-gray-500 text-sm">Manage all registered users, their courses and exams</p>
                </div>
                @role('admin')
    <a href="/admin/users/create"
       class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-purple-200 transition-all duration-300 hover:shadow-xl hover:shadow-purple-300 hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        Add User
    </a>
@endrole
            </div>
        </div>

        <!-- Users Grid -->
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($users as $user)
                <div class="group relative bg-white/80 backdrop-blur-sm border border-purple-100/50 rounded-2xl p-6 hover:shadow-2xl hover:shadow-purple-100/50 transition-all duration-500 hover:-translate-y-1">

                    <!-- Purple accent line -->
                    <div class="absolute top-0 left-6 right-6 h-1 bg-gradient-to-r from-purple-500 via-violet-500 to-indigo-500 rounded-b-full"></div>

                    <!-- User Avatar & Info -->
                    <div class="flex items-start gap-4 mb-5 mt-2">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-purple-200 flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-gray-800 truncate">
                                {{ $user->name }}
                            </h2>
                            <p class="text-sm text-gray-400 truncate">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    <!-- Courses Section -->
                    <div class="mb-5">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Courses</span>
                            <span class="ml-auto text-xs font-medium text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $user->enrolledCourses->count() }}</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($user->enrolledCourses as $course)
                                <span class="inline-block bg-gradient-to-r from-purple-50 to-indigo-50 text-purple-700 border border-purple-200/50 px-2.5 py-1 rounded-lg text-xs font-medium">
                                    {{ $course->title }}
                                </span>
                            @empty
                                <p class="text-gray-300 text-xs italic">No courses enrolled</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Exams Section -->
                    <div class="mb-5">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Exams</span>
                            <span class="ml-auto text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">{{ $user->exams->count() }}</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($user->exams as $exam)
                                <span class="inline-block bg-gradient-to-r from-indigo-50 to-violet-50 text-indigo-700 border border-indigo-200/50 px-2.5 py-1 rounded-lg text-xs font-medium">
                                    {{ $exam->title ?? 'Exam' }}
                                </span>
                            @empty
                                <p class="text-gray-300 text-xs italic">No exams taken</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-4 border-t border-purple-100/50">
                        <a href="{{ url('/users/' . $user->id . '/exams') }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-300 shadow-md shadow-purple-200 hover:shadow-lg hover:shadow-purple-300">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            View Exams
                        </a>
                        @role('admin')
    <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
       class="flex-1 inline-flex items-center justify-center gap-1.5 bg-white hover:bg-purple-50 text-purple-700 border border-purple-200 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-300">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit User
    </a>
@endrole
                    </div>

                </div>
            @endforeach

        </div>

    </div>
</x-app-layout>