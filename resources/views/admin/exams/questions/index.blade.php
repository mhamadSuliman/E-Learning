<x-app-layout>

<style>
    .dashboard-bg {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        min-height: 100vh;
    }
    .glass {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(16px);
    }
    .glass-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.07);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        background: rgba(167,139,250,0.07);
        border-color: rgba(167,139,250,0.3);
        transform: translateY(-2px);
        box-shadow: 0 0 25px rgba(139,92,246,0.15);
    }
    .glass-form {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(167,139,250,0.25);
        backdrop-filter: blur(20px);
    }
    .input-dark {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        transition: all 0.3s;
    }
    .input-dark::placeholder { color: rgba(255,255,255,0.3); }
    .input-dark:focus {
        outline: none;
        border-color: rgba(167,139,250,0.6);
        box-shadow: 0 0 15px rgba(139,92,246,0.2);
        background: rgba(255,255,255,0.07);
    }
    .badge {
        background: linear-gradient(90deg, #a78bfa, #60a5fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
    }
    .glow-btn { transition: all 0.3s ease; }
    .glow-btn:hover { transform: translateY(-2px); }
    .pulse-dot { animation: pulse 2s infinite; }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    .option-badge {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 4px 10px;
        color: rgba(255,255,255,0.6);
        font-size: 12px;
    }
    .correct-badge {
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(34,197,94,0.3);
        color: #4ade80;
        border-radius: 8px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: bold;
    }
    .number-circle {
        background: linear-gradient(135deg, #7c3aed, #2563eb);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 900;
        color: white;
        flex-shrink: 0;
    }
</style>

<div class="dashboard-bg p-6 md:p-10" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="pulse-dot w-2 h-2 bg-green-400 rounded-full inline-block"></span>
                <span class="text-green-400 text-xs tracking-widest uppercase">إدارة الأسئلة</span>
            </div>
            <h1 class="text-4xl font-black text-white" style="text-shadow: 0 0 20px rgba(167,139,250,0.6)">
                📝 {{ $exam->title }}
            </h1>
            <p class="text-purple-300 text-sm mt-1">
                إجمالي الأسئلة:
                <span class="text-white font-bold">{{ $exam->questions->count() }}</span>
            </p>
        </div>

        <button onclick="document.getElementById('addForm').classList.toggle('hidden')"
                class="glow-btn inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold px-6 py-3 rounded-2xl shadow-lg hover:shadow-green-500/30">
            ➕ إضافة سؤال جديد
        </button>
    </div>

    {{-- Add Form --}}
    <div id="addForm" class="glass-form rounded-3xl p-6 md:p-8 mb-10 hidden">
        <h2 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-purple-600/50 flex items-center justify-center text-sm">✏️</span>
            سؤال جديد
        </h2>

        <form method="POST" action="/admin/exams/{{ $exam->id }}/questions" class="space-y-4">
            @csrf

            {{-- Question --}}
            <div>
                <label class="text-purple-300 text-xs font-bold tracking-widest uppercase block mb-2">نص السؤال</label>
                <input name="question"
                       placeholder="اكتب السؤال هنا..."
                       class="input-dark w-full rounded-xl px-4 py-3 text-sm">
            </div>

            {{-- Type --}}
            <div>
                <label class="text-purple-300 text-xs font-bold tracking-widest uppercase block mb-2">نوع السؤال</label>
                <select name="type" class="input-dark w-full rounded-xl px-4 py-3 text-sm">
                    <option value="multiple_choice" class="bg-gray-900">اختيار من متعدد</option>
                    <option value="true_false" class="bg-gray-900">صح / خطأ</option>
                </select>
            </div>

            {{-- Options --}}
            <div>
                <label class="text-purple-300 text-xs font-bold tracking-widest uppercase block mb-2">الخيارات</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach(['A' => 'الخيار A', 'B' => 'الخيار B', 'C' => 'الخيار C', 'D' => 'الخيار D'] as $key => $label)
                    <div class="relative">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-lg bg-purple-600/40 text-purple-300 text-xs flex items-center justify-center font-bold">{{ $key }}</span>
                        <input name="options[]"
                               placeholder="{{ $label }}"
                               class="input-dark w-full rounded-xl pr-10 pl-4 py-3 text-sm">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Correct Answer --}}
            <div>
                <label class="text-purple-300 text-xs font-bold tracking-widest uppercase block mb-2">الإجابة الصحيحة</label>
                <input name="correct_answer"
                       placeholder="اكتب الإجابة الصحيحة..."
                       class="input-dark w-full rounded-xl px-4 py-3 text-sm">
            </div>

            {{-- Submit --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="glow-btn flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 rounded-xl hover:shadow-lg hover:shadow-purple-500/30">
                    💾 حفظ السؤال
                </button>
                <button type="button"
                        onclick="document.getElementById('addForm').classList.add('hidden')"
                        class="glow-btn px-6 bg-white/5 border border-white/10 text-white/60 hover:text-white font-semibold py-3 rounded-xl">
                    إلغاء
                </button>
            </div>

        </form>
    </div>

    {{-- Questions List --}}
    <div class="space-y-4">

        @forelse($exam->questions as $index => $question)
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-start justify-between gap-4">

                {{-- Question Content --}}
                <div class="flex items-start gap-4 flex-1">
                    <div class="number-circle">{{ $index + 1 }}</div>
                    <div class="flex-1">
                        <p class="text-white font-semibold text-base leading-relaxed mb-3">
                            {{ $question->question }}
                        </p>

                        {{-- Options --}}
                        @if($question->options)
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($question->options as $option)
                            <span class="option-badge">• {{ $option }}</span>
                            @endforeach
                        </div>
                        @endif

                        {{-- Correct Answer --}}
                        <div class="flex items-center gap-2">
                            <span class="text-white/30 text-xs">الإجابة:</span>
                            <span class="correct-badge">✅ {{ $question->correct_answer }}</span>
                        </div>
                    </div>
                </div>

                {{-- Delete --}}
                <form method="POST" action="/admin/exams/{{ $exam->id }}/questions/{{ $question->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('هل أنت متأكد من حذف هذا السؤال؟')"
                            class="glow-btn inline-flex items-center gap-1 bg-red-500/20 border border-red-500/30 text-red-400 hover:text-white hover:bg-red-500 text-xs font-semibold px-3 py-2 rounded-xl transition-all">
                        🗑️ حذف
                    </button>
                </form>

            </div>
        </div>
        @empty
        <div class="glass rounded-3xl flex flex-col items-center justify-center py-24 text-white/30">
            <div class="text-6xl mb-4">📭</div>
            <div class="text-lg font-semibold mb-1">لا توجد أسئلة بعد</div>
            <p class="text-sm text-white/20">اضغط على "إضافة سؤال جديد" للبدء</p>
        </div>
        @endforelse

    </div>

    {{-- Footer --}}
    @if($exam->questions->count() > 0)
    <div class="mt-6 text-center text-white/20 text-xs">
        {{ $exam->questions->count() }} سؤال في هذا الامتحان
    </div>
    @endif

</div>

</x-app-layout>