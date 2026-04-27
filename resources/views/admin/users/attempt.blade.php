<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 p-4 sm:p-8">

        <div class="max-w-4xl mx-auto">

            <!-- Back Link -->
            <a href__="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-purple-600 hover:text-purple-800 text-sm font-medium mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>

            <!-- Score Card -->
            <div class="bg-white/80 backdrop-blur-sm border border-purple-100/50 rounded-2xl shadow-xl shadow-purple-100/30 p-6 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-purple-700 to-indigo-600 bg-clip-text text-transparent">
                            {{ $attempt->exam->title }}
                        </h1>
                        <p class="text-gray-400 text-sm mt-1">Detailed exam review</p>
                    </div>
                    @php $score = $attempt->score ?? 0; @endphp
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Score</p>
                            <p class="text-3xl font-extrabold {{ $score >= 80 ? 'text-green-500' : ($score >= 50 ? 'text-amber-500' : 'text-red-500') }}">
                                {{ $score }}
                            </p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl {{ $score >= 80 ? 'bg-green-100' : ($score >= 50 ? 'bg-amber-100' : 'bg-red-100') }} flex items-center justify-center">
                            @if($score >= 80)
                                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($score >= 50)
                                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            @else
                                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answers -->
            <div class="space-y-4">
                @foreach($attempt->answers as $index => $answer)
                    <div class="bg-white/80 backdrop-blur-sm border rounded-2xl p-5 transition-all duration-300
                        {{ $answer->is_correct ? 'border-green-200/50 hover:shadow-lg hover:shadow-green-100/30' : 'border-red-200/50 hover:shadow-lg hover:shadow-red-100/30' }}">

                        <div class="flex items-start gap-4">
                            <!-- Question Number -->
                            <div class="w-8 h-8 rounded-lg flex-shrink-0 flex items-center justify-center text-sm font-bold
                                {{ $answer->is_correct ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $index + 1 }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <!-- Question -->
                                <p class="font-semibold text-gray-800 mb-3">
                                    {{ $answer->question->question }}
                                </p>

                                <!-- Answers -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm
                                        {{ $answer->is_correct ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                        <span class="font-medium {{ $answer->is_correct ? 'text-green-700' : 'text-red-700' }}">Your answer:</span>
                                        <span class="{{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">{{ $answer->selected_answer }}</span>
                                    </div>
                                    @if(!$answer->is_correct)
                                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm bg-green-50 border border-green-200">
                                            <span class="font-medium text-green-700">Correct:</span>
                                            <span class="text-green-600">{{ $answer->question->correct_answer }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status Icon -->
                            <div class="flex-shrink-0 mt-1">
                                @if($answer->is_correct)
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>