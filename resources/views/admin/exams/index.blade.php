<x-app-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    .dashboard-bg {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        background: linear-gradient(135deg, #1e1033 0%, #2d1b69 25%, #1a0a3e 50%, #2d1b69 75%, #1e1033 100%);
        background-attachment: fixed;
        position: relative;
    }
    .bg-orb { position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.25; pointer-events: none; z-index: 0; }
    .bg-orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, #a855f7, transparent); top: -150px; left: -100px; }
    .bg-orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, #7c3aed, transparent); bottom: -100px; right: -80px; }
    .grid-overlay {
        position: fixed; inset: 0;
        background-image: linear-gradient(rgba(168,85,247,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(168,85,247,0.03) 1px, transparent 1px);
        background-size: 60px 60px; pointer-events: none; z-index: 0;
    }
    .page-content { position: relative; z-index: 1; }

    .glass-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(168,85,247,0.12);
        backdrop-filter: blur(16px);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .glass-card:hover {
        background: rgba(168,85,247,0.06);
        border-color: rgba(168,85,247,0.25);
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(139,92,246,0.12);
    }

    .add-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #059669, #10b981);
        color: white; font-weight: 700; padding: 12px 24px;
        border-radius: 14px; font-size: 0.9rem; font-family: 'Inter', sans-serif;
        transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(5,150,105,0.3);
        text-decoration: none;
    }
    .add-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(16,185,129,0.4); }

    .action-link {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 10px;
        font-size: 0.8rem; font-weight: 600;
        transition: all 0.2s ease; text-decoration: none;
    }
    .action-view { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); color: #4ade80; }
    .action-view:hover { background: rgba(34,197,94,0.2); }
    .action-edit { background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.25); color: #60a5fa; }
    .action-edit:hover { background: rgba(96,165,250,0.2); }
    .action-delete {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 10px;
        font-size: 0.8rem; font-weight: 600;
        background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
        color: #f87171; cursor: pointer; transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }
    .action-delete:hover { background: rgba(239,68,68,0.2); }

    .th-cell {
        padding: 14px 20px;
        color: rgba(216,180,254,0.45);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }
    .td-cell {
        padding: 16px 20px;
        color: #f3e8ff;
        font-size: 0.9rem;
        border-top: 1px solid rgba(168,85,247,0.06);
    }
    .empty-state {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(168,85,247,0.08);
        border-radius: 20px;
    }
    .duration-badge {
        background: rgba(168,85,247,0.1);
        border: 1px solid rgba(168,85,247,0.2);
        color: #d8b4fe;
        border-radius: 8px;
        padding: 3px 10px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .pulse-dot { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
</style>

<div class="dashboard-bg">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="grid-overlay"></div>

    <div class="page-content p-6 md:p-10 max-w-5xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="pulse-dot w-2 h-2 bg-purple-400 rounded-full inline-block"></span>
                    <span class="text-purple-400 text-xs tracking-widest uppercase font-semibold">إدارة الامتحانات</span>
                </div>
                <h1 class="text-4xl font-black text-white mb-1" style="text-shadow: 0 0 20px rgba(167,139,250,0.5)">
                    📝 Exams
                </h1>
                <p class="text-purple-300/50 text-sm">
                    Course:
                    <span class="text-purple-300 font-semibold">{{ $course->title }}</span>
                    &nbsp;·&nbsp;
                    <span class="text-white font-bold">{{ $course->exams->count() }}</span> exams
                </p>
            </div>

            <a href="/admin/courses/{{ $course->id }}/exams/create" class="add-btn">
                ➕ Add Exam
            </a>
        </div>

        <!-- Table -->
        @if($course->exams->count() > 0)
        <div class="glass-card overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="th-cell text-left">#</th>
                        <th class="th-cell text-left">Title</th>
                        <th class="th-cell text-left">Course</th>
                        <th class="th-cell text-left">Duration</th>
                        <th class="th-cell text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->exams as $index => $exam)
                    <tr>
                        <td class="td-cell">
                            <span style="color:rgba(168,85,247,0.5); font-weight:700;">{{ $index + 1 }}</span>
                        </td>
                        <td class="td-cell font-semibold">{{ $exam->title }}</td>
                        <td class="td-cell" style="color:rgba(216,180,254,0.6);">{{ $exam->course->title ?? '-' }}</td>
                        <td class="td-cell">
                            <span class="duration-badge">⏱ {{ $exam->duration }} min</span>
                        </td>
                        <td class="td-cell">
                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                <a href="/admin/courses/{{ $course->id }}/exams/{{ $exam->id }}" class="action-link action-view">
                                    👁 View
                                </a>
                                <a href="/admin/courses/{{ $course->id }}/exams/{{ $exam->id }}/edit" class="action-link action-edit">
                                    ✏️ Edit
                                </a>
                                <form method="POST" action="/admin/courses/{{ $course->id }}/exams/{{ $exam->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete this exam?')"
                                            class="action-delete">
                                        🗑 Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <div class="empty-state flex flex-col items-center justify-center py-24 text-white/30">
            <div class="text-6xl mb-4">📭</div>
            <div class="text-lg font-semibold mb-1">No exams yet</div>
            <p class="text-sm text-white/20">Click "Add Exam" to get started</p>
        </div>
        @endif

    </div>
</div>

</x-app-layout>