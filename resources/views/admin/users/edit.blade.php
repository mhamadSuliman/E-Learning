<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 p-4 sm:p-8">

        <div class="max-w-xl mx-auto">

            <!-- Back Link -->
            <a href__="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-purple-600 hover:text-purple-800 text-sm font-medium mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>

            <!-- Card -->
            <div class="bg-white/80 backdrop-blur-sm border border-purple-100/50 rounded-2xl shadow-xl shadow-purple-100/30 overflow-hidden">

                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-600 via-violet-600 to-indigo-600 p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Edit User</h1>
                            <p class="text-purple-200 text-sm">Update user information</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="/admin/users/{{ $user->id }}" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input name="name" value="{{ $user->name }}"
                               class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Enter full name">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <input name="email" value="{{ $user->email }}"
                               class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Enter email address">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
                        <input name="password" type="password"
                               class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Leave empty to keep current password">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                        <select name="role"
                                class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                            <option value="instructor" {{ $user->role == 'instructor' ? 'selected' : '' }}>🎓 Instructor</option>
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>📖 Student</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3.5 rounded-xl font-semibold shadow-lg shadow-purple-200 hover:shadow-xl hover:shadow-purple-300 transition-all duration-300 hover:-translate-y-0.5">
                        Update User
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>