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
    .glass-form { background: rgba(255,255,255,0.04); border: 1px solid rgba(168,85,247,0.2); backdrop-filter: blur(20px); border-radius: 24px; }
    .input-dark {
        width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);
        color: white; border-radius: 14px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s; font-family: 'Inter', sans-serif;
    }
    .input-dark::placeholder { color: rgba(255,255,255,0.25); }
    .input-dark:focus { outline: none; border-color: rgba(168,85,247,0.6); box-shadow: 0 0 20px rgba(139,92,246,0.2); background: rgba(255,255,255,0.07); }
    .field-label { display: block; color: rgba(216,180,254,0.6); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 8px; }
    .update-btn {
        background: linear-gradient(135deg, #2563eb, #7c3aed); color: white; font-weight: 700; padding: 14px 32px;
        border-radius: 14px; border: none; cursor: pointer; font-size: 1rem; font-family: 'Inter', sans-serif;
        transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(37,99,235,0.35);
    }
    .update-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(124,58,237,0.5); }
    .pulse-dot { animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
    .current-value-tag {
        font-size: 0.7rem; color: rgba(96,165,250,0.7); font-weight: 500;
        background: rgba(37,99,235,0.08); border: 1px solid rgba(37,99,235,0.2);
        border-radius: 50px; padding: 2px 10px; margin-top: 6px; display: inline-block;
    }
</style>

<div class="dashboard-bg">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="grid-overlay"></div>

    <div class="page-content p-6 md:p-10 max-w-2xl mx-auto">

        <div class="mb-10">
            <div class="flex items-center gap-2 mb-3">
                <span class="pulse-dot w-2 h-2 bg-blue-400 rounded-full inline-block"></span>
                <span class="text-blue-400 text-xs tracking-widest uppercase font-semibold">تعديل الامتحان</span>
            </div>
            <h1 class="text-4xl font-black text-white mb-2" style="text-shadow: 0 0 20px rgba(96,165,250,0.5)">
                ✏️ Edit Exam
            </h1>
            <p class="text-purple-300/50 text-sm">Update exam details below</p>
        </div>

        <div class="glass-form p-8">
            <form method="POST" action="/admin/courses/{{ $course->id }}/exams/{{ $exam->id }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="field-label">📌 Exam Title</label>
                    <input name="title" value="{{ $exam->title }}" class="input-dark">
                    <span class="current-value-tag">Current: {{ $exam->title }}</span>
                </div>

                <div>
                    <label class="field-label">📝 Description</label>
                    <textarea name="description" class="input-dark" rows="4" style="resize:vertical;">{{ $exam->description }}</textarea>
                </div>

                <div>
                    <label class="field-label">⏱️ Duration (minutes)</label>
                    <input name="duration" type="number" value="{{ $exam->duration }}" class="input-dark">
                    <span class="current-value-tag">Current: {{ $exam->duration }} min</span>
                </div>

                <div>
                    <label class="field-label">📚 Course</label>
                    <select name="course_id" class="input-dark">
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ $exam->course_id == $c->id ? 'selected' : '' }} style="background:#1e1033">
                                {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="update-btn">🔄 Update Exam</button>
                </div>

            </form>
        </div>

    </div>
</div>

</x-app-layout>