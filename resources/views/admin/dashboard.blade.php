<x-app-layout>

<style>
    .dashboard-bg {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        min-height: 100vh;
    }
    .card-glow {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
    }
    .card-glow:hover {
        transform: translateY(-6px);
        box-shadow: 0 0 30px rgba(139, 92, 246, 0.4);
        border-color: rgba(139, 92, 246, 0.6);
    }
    .glow-text {
        text-shadow: 0 0 20px rgba(167, 139, 250, 0.8);
    }
    .stat-number {
        background: linear-gradient(90deg, #a78bfa, #60a5fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .chart-container {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
    }
    .pulse-dot {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
    .shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>

<div class="dashboard-bg p-6 md:p-10" dir="rtl">

    {{-- Header --}}
    <div class="mb-10 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="pulse-dot w-3 h-3 bg-green-400 rounded-full inline-block"></span>
                <span class="text-green-400 text-sm font-medium tracking-widest uppercase">Live Dashboard</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white glow-text tracking-tight">
                👑 لوحة التحكم
            </h1>
            <p class="text-purple-300 mt-2 text-sm">{{ now()->format('l, d M Y — H:i') }}</p>
        </div>
        <div class="hidden md:flex items-center gap-2 bg-white/5 border border-white/10 rounded-2xl px-5 py-3">
            <span class="w-2 h-2 rounded-full bg-purple-400 pulse-dot"></span>
            <span class="text-white/70 text-sm">النظام يعمل بشكل طبيعي</span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-10">

        @php
            $cards = [
                ['icon' => '👥', 'label' => 'المستخدمون',  'value' => $users,        'color' => 'from-violet-500 to-purple-700'],
                ['icon' => '🎓', 'label' => 'الطلاب',       'value' => $students,     'color' => 'from-blue-500 to-cyan-600'],
                ['icon' => '👨‍🏫', 'label' => 'المدرّسون',   'value' => $instructors,  'color' => 'from-fuchsia-500 to-pink-600'],
                ['icon' => '📚', 'label' => 'الكورسات',     'value' => $courses,      'color' => 'from-indigo-500 to-blue-700'],
                ['icon' => '💳', 'label' => 'المدفوعات',    'value' => $payments,     'color' => 'from-orange-500 to-amber-600'],
                ['icon' => '💰', 'label' => 'الإيرادات',    'value' => '$'.number_format($totalRevenue,2), 'color' => 'from-emerald-500 to-teal-600'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="card-glow rounded-2xl p-5 shimmer relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br {{ $card['color'] }} opacity-10 rounded-2xl"></div>
            <div class="relative z-10">
                <div class="text-3xl mb-3">{{ $card['icon'] }}</div>
                <div class="text-white/50 text-xs font-medium mb-1 tracking-wider uppercase">{{ $card['label'] }}</div>
                <div class="text-3xl font-black stat-number">{{ $card['value'] }}</div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Chart Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Doughnut Chart --}}
        <div class="chart-container rounded-3xl p-6 flex flex-col items-center">
            <h2 class="text-white font-bold text-lg mb-6 self-start">📊 توزيع المستخدمين</h2>
            <div class="w-56 h-56 relative">
                <canvas id="usersChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <div class="text-white/40 text-xs">الإجمالي</div>
                    <div class="text-white font-black text-2xl">{{ $users }}</div>
                </div>
            </div>
            <div class="mt-6 w-full space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-400 inline-block"></span>
                        <span class="text-white/60 text-sm">الطلاب</span>
                    </div>
                    <span class="text-white font-bold">{{ $students }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-fuchsia-400 inline-block"></span>
                        <span class="text-white/60 text-sm">المدرّسون</span>
                    </div>
                    <span class="text-white font-bold">{{ $instructors }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-orange-400 inline-block"></span>
                        <span class="text-white/60 text-sm">المدراء</span>
                    </div>
                    <span class="text-white font-bold">{{ $admins }}</span>
                </div>
            </div>
        </div>

        {{-- Revenue Bar --}}
        <div class="chart-container rounded-3xl p-6 lg:col-span-2">
            <h2 class="text-white font-bold text-lg mb-6">💵 الإيرادات الشهرية</h2>
            <canvas id="revenueChart" height="200"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Doughnut Chart
    new Chart(document.getElementById('usersChart'), {
        type: 'doughnut',
        data: {
            labels: ['الطلاب', 'المدرّسون', 'المدراء'],
            datasets: [{
                data: [{{ $students }}, {{ $instructors }}, {{ $admins }}],
                backgroundColor: ['#60a5fa', '#e879f9', '#fb923c'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });

    // Revenue Bar Chart (بيانات تجريبية — استبدلها ببياناتك الحقيقية)
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'],
            datasets: [{
                label: 'الإيرادات ($)',
                data: [1200, 1900, 1500, 2800, 2200, 3100, 2700, 3500, 3000, 4200, 3800, {{ $totalRevenue }}],
                backgroundColor: 'rgba(167, 139, 250, 0.3)',
                borderColor: '#a78bfa',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(167, 139, 250, 0.6)',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 11 } },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                y: {
                    ticks: { color: 'rgba(255,255,255,0.4)' },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                }
            }
        }
    });
</script>

</x-app-layout>