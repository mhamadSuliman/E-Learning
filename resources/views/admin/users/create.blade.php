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
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Create User</h1>
                            <p class="text-purple-200 text-sm">Add a new user to the system</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="/admin/users" class="p-6 space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input name="name"
                               class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Enter full name">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <input name="email" type="email"
                               class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Enter email address">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <input name="password" type="password"
                               class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Create a strong password">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                        <select name="role"
                                class="w-full px-4 py-3 rounded-xl border border-purple-200/50 bg-purple-50/30 text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                            <option value="admin">👑 Admin</option>
                            <option value="instructor">🎓 Instructor</option>
                            <option value="student" selected>📖 Student</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3.5 rounded-xl font-semibold shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 transition-all duration-300 hover:-translate-y-0.5">
                        Create User
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>