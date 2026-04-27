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
    .glass-row {
        background: rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.06);
        transition: all 0.3s ease;
    }
    .glass-row:hover {
        background: rgba(167,139,250,0.08);
        transform: scale(1.005);
        box-shadow: 0 0 20px rgba(139,92,246,0.15);
    }
    .glow-btn {
        transition: all 0.3s ease;
    }
    .glow-btn:hover {
        box-shadow: 0 0 20px rgba(34,197,94,0.5);
        transform: translateY(-2px);
    }
    .badge {
        background: linear-gradient(90deg, #a78bfa, #60a5fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
    }
    .pulse-dot {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    .delete-btn:hover { box-shadow: 0 0 15px rgba(239,68,68,0.5); }
    .edit-btn:hover   { box-shadow: 0 0 15px rgba(96,165,250,0.5); }
    .exam-btn:hover   { box-shadow: 0 0 15px rgba(192,132,252,0.5); }
</style>

<div class="dashboard-bg p-6 md:p-10" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="pulse-dot w-2 h-2 bg-green-400 rounded-full inline-block"></span>
                <span class="text-green-400 text-xs tracking-widest uppercase">إدارة الكورسات</span>
            </div>
            <h1 class="text-4xl font-black text-white" style="text-shadow: 0 0 20px rgba(167,139,250,0.6)">
                📚 الكورسات
            </h1>
            <p class="text-purple-300 text-sm mt-1">إجمالي الكورسات: <span class="text-white font-bold">{{ count($courses) }}</span></p>
        </div>

        <a href="/admin/courses/create"
           class="glow-btn inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold px-6 py-3 rounded-2xl shadow-lg">
            ➕ إضافة كورس جديد
        </a>
    </div>

    {{-- Table --}}
    <div class="glass rounded-3xl overflow-hidden">

        {{-- Table Header --}}
        <div class="grid grid-cols-4 px-6 py-4 border-b border-white/10">
            <div class="text-purple-300 text-xs font-bold tracking-widest uppercase">عنوان الكورس</div>
            <div class="text-purple-300 text-xs font-bold tracking-widest uppercase text-center">المدرّس</div>
            <div class="text-purple-300 text-xs font-bold tracking-widest uppercase text-center">السعر</div>
            <div class="text-purple-300 text-xs font-bold tracking-widest uppercase text-center">الإجراءات</div>
        </div>

        {{-- Rows --}}
        @forelse($courses as $course)
        <div class="glass-row grid grid-cols-4 items-center px-6 py-4">

            {{-- Title --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                    {{ mb_substr($course->title, 0, 1) }}
                </div>
                <span class="text-white font-semibold text-sm">{{ $course->title }}</span>
            </div>

            {{-- Instructor --}}
            <div class="text-center">
                @if($course->instructor)
                    <span class="inline-flex items-center gap-1 bg-white/5 border border-white/10 rounded-full px-3 py-1 text-white/80 text-xs">
                        👨‍🏫 {{ $course->instructor->name }}
                    </span>
                @else
                    <span class="text-white/30 text-xs">—</span>
                @endif
            </div>

            {{-- Price --}}
            <div class="text-center">
                <span class="badge text-lg">${{ number_format($course->price, 2) }}</span>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-center gap-2 flex-wrap">

                <a href="/admin/courses/{{ $course->id }}/edit"
                   class="edit-btn glow-btn inline-flex items-center gap-1 bg-blue-500/20 border border-blue-500/40 text-blue-400 hover:text-white hover:bg-blue-500 text-xs font-semibold px-3 py-2 rounded-xl transition-all">
                    ✏️ تعديل
                </a>

                <a href="/admin/courses/{{ $course->id }}/exams"
                   class="exam-btn glow-btn inline-flex items-center gap-1 bg-purple-500/20 border border-purple-500/40 text-purple-400 hover:text-white hover:bg-purple-500 text-xs font-semibold px-3 py-2 rounded-xl transition-all">
                    📝 الامتحانات
                </a>

                <form method="POST" action="/admin/courses/{{ $course->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('هل أنت متأكد من حذف هذا الكورس؟')"
                            class="delete-btn glow-btn inline-flex items-center gap-1 bg-red-500/20 border border-red-500/40 text-red-400 hover:text-white hover:bg-red-500 text-xs font-semibold px-3 py-2 rounded-xl transition-all">
                        🗑️ حذف
                    </button>
                </form>

            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-20 text-white/30">
            <div class="text-6xl mb-4">📭</div>
            <div class="text-lg font-semibold">لا توجد كورسات بعد</div>
            <a href="/admin/courses/create" class="mt-4 text-purple-400 hover:text-purple-300 underline text-sm">إضافة أول كورس</a>
        </div>
        @endforelse

    </div>

    {{-- Footer count --}}
    @if(count($courses) > 0)
    <div class="mt-4 text-center text-white/20 text-xs">
        عرض {{ count($courses) }} كورس
    </div>
    @endif

</div>

</x-app-layout>