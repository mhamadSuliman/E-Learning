<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 p-4 sm:p-8">

        <div class="max-w-4xl mx-auto">

            <!-- Header -->
            <div class="mb-8">
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-purple-600 hover:text-purple-800 text-sm font-medium mb-4 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                    Back
                </a>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-200">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-purple-700 to-indigo-600 bg-clip-text text-transparent">
                            {{ $user->name }}'s Exams
                        </h1>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $attempts->count() }} exam{{ $attempts->count() !== 1 ? 's' : '' }} taken</p>
                    </div>
                </div>
            </div>

            <!-- Exams List -->
            <div class="space-y-4">
                @forelse($attempts as $attempt)
                    <div class="group bg-white/80 backdrop-blur-sm border border-purple-100/50 rounded-2xl p-5 hover:shadow-xl hover:shadow-purple-100/50 transition-all duration-500 hover:-translate-y-0.5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-800 text-lg">
                                        {{ $attempt->exam->title ?? 'Exam' }}
                                    </h2>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-sm text-gray-400">Score:</span>
                                        @php $score = $attempt->score ?? 0; @endphp
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-sm font-bold
                                            {{ $score >= 80 ? 'bg-green-50 text-green-600' : ($score >= 50 ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                            {{ $score }}%
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ url('/attempts/' . $attempt->id) }}"
                               class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-purple-200 hover:shadow-lg hover:shadow-purple-300 transition-all duration-300 hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View Details
                            </a>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white/60 rounded-2xl border border-purple-100/50">
                        <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <p class="text-gray-400 font-medium">No exams taken yet</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>