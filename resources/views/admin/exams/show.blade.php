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

    .glass-panel {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(168,85,247,0.15);
        backdrop-filter: blur(20px);
        border-radius: 24px;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 18px 0;
        border-bottom: 1px solid rgba(168,85,247,0.07);
    }
    .info-row:last-child { border-bottom: none; }

    .info-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
        background: rgba(168,85,247,0.1);
        border: 1px solid rgba(168,85,247,0.15);
    }

    .info-label {
        font-size: 0.72rem;
        color: rgba(216,180,254,0.45);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .info-value {
        color: #f3e8ff;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.6;
    }

    .action-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 13px 26px; border-radius: 14px;
        font-size: 0.9rem; font-weight: 700;
        transition: all 0.3s ease; text-decoration: none;
        font-family: 'Inter', sans-serif;
    }
    .btn-edit {
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        color: white;
        box-shadow: 0 4px 20px rgba(37,99,235,0.3);
    }
    .btn-edit:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(124,58,237,0.4); }
    .btn-questions {
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        color: white;
        box-shadow: 0 4px 20px rgba(124,58,237,0.3);
    }
    .btn-questions:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(168,85,247,0.4); }

    .duration-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(168,85,247,0.12);
        border: 1px solid rgba(168,85,247,0.22);
        color: #d8b4fe; border-radius: 10px; padding: 5px 14px;
        font-size: 0.85rem; font-weight: 700;
    }

    .pulse-dot { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
</style>

<div class="dashboard-bg">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="grid-overlay"></div>

    <div class="page-content p-6 md:p-10 max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
                <span class="pulse-dot w-2 h-2 bg-purple-400 rounded-full inline-block"></span>
                <span class="text-purple-400 text-xs tracking-widest uppercase font-semibold">تفاصيل الامتحان</span>
            </div>
            <h1 class="text-4xl font-black text-white mb-2" style="text-shadow: 0 0 20px rgba(167,139,250,0.5)">
                {{ $exam->title }}
            </h1>
        </div>

        <!-- Info Panel -->
        <div class="glass-panel p-8 mb-8">
            <div class="info-row">
                <div class="info-icon">📝</div>
                <div>
                    <p class="info-label">Description</p>
                    <p class="info-value">{{ $exam->description ?: '—' }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon">⏱️</div>
                <div>
                    <p class="info-label">Duration</p>
                    <span class="duration-badge">{{ $exam->duration }} minutes</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-wrap gap-4">
            <a href="/admin/exams/{{ $exam->id }}/edit" class="action-btn btn-edit">
                ✏️ Edit Exam
            </a>
            <a href="/admin/exams/{{ $exam->id }}/questions" class="action-btn btn-questions">
                🧠 Manage Questions
            </a>
        </div>

    </div>
</div>

</x-app-layout>