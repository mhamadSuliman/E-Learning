<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        :root {
            --purple-50: #faf5ff;
            --purple-100: #f3e8ff;
            --purple-200: #e9d5ff;
            --purple-300: #d8b4fe;
            --purple-400: #c084fc;
            --purple-500: #a855f7;
            --purple-600: #9333ea;
            --purple-700: #7e22ce;
            --purple-800: #6b21a8;
            --purple-900: #581c87;
            --purple-950: #3b0764;
        }

        .instructor-dashboard {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e1033 0%, #2d1b69 25%, #1a0a3e 50%, #2d1b69 75%, #1e1033 100%);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background orbs */
        .bg-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: floatOrb 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        .bg-orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #a855f7, transparent);
            top: -200px; left: -100px;
            animation-delay: 0s;
        }

        .bg-orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #7c3aed, transparent);
            bottom: -150px; right: -100px;
            animation-delay: -7s;
        }

        .bg-orb-3 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #c084fc, transparent);
            top: 40%; left: 50%;
            animation-delay: -14s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -40px) scale(1.05); }
            50% { transform: translate(-20px, 20px) scale(0.95); }
            75% { transform: translate(40px, 30px) scale(1.02); }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(168, 85, 247, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }

        .dashboard-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .header-section {
            margin-bottom: 2.5rem;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .greeting-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(168, 85, 247, 0.15);
            border: 1px solid rgba(168, 85, 247, 0.25);
            border-radius: 50px;
            color: #d8b4fe;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .greeting-badge .pulse-dot {
            width: 8px; height: 8px;
            background: #a855f7;
            border-radius: 50%;
            animation: pulseDot 2s ease-in-out infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #e9d5ff 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .header-subtitle {
            color: rgba(216, 180, 254, 0.6);
            font-size: 1.05rem;
            font-weight: 400;
        }

        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .header-title { font-size: 1.8rem; }
            .dashboard-content { padding: 1rem; }
            .two-col-grid { grid-template-columns: 1fr !important; }
        }

        .stat-card {
            position: relative;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(168, 85, 247, 0.15);
            border-radius: 20px;
            padding: 1.75rem;
            backdrop-filter: blur(20px);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeUp 0.6s ease-out backwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card:hover {
            transform: translateY(-6px);
            border-color: rgba(168, 85, 247, 0.4);
            background: rgba(255, 255, 255, 0.07);
            box-shadow: 0 20px 60px rgba(168, 85, 247, 0.15);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
        }

        .stat-card:nth-child(1)::before {
            background: linear-gradient(90deg, #a855f7, #c084fc);
        }
        .stat-card:nth-child(2)::before {
            background: linear-gradient(90deg, #7c3aed, #a78bfa);
        }
        .stat-card:nth-child(3)::before {
            background: linear-gradient(90deg, #6d28d9, #8b5cf6);
        }

        .stat-glow {
            position: absolute;
            width: 120px; height: 120px;
            border-radius: 50%;
            filter: blur(50px);
            opacity: 0.15;
            top: -30px; right: -30px;
        }

        .stat-card:nth-child(1) .stat-glow { background: #a855f7; }
        .stat-card:nth-child(2) .stat-glow { background: #7c3aed; }
        .stat-card:nth-child(3) .stat-glow { background: #6d28d9; }

        .stat-icon-wrapper {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            font-size: 1.5rem;
            position: relative;
        }

        .stat-card:nth-child(1) .stat-icon-wrapper {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(192, 132, 252, 0.1));
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
        .stat-card:nth-child(2) .stat-icon-wrapper {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(167, 139, 250, 0.1));
            border: 1px solid rgba(124, 58, 237, 0.3);
        }
        .stat-card:nth-child(3) .stat-icon-wrapper {
            background: linear-gradient(135deg, rgba(109, 40, 217, 0.2), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(109, 40, 217, 0.3);
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: rgba(216, 180, 254, 0.5);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #f3e8ff;
            line-height: 1;
            margin-bottom: 0.75rem;
        }

        .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #a3e635;
            background: rgba(163, 230, 53, 0.1);
            padding: 4px 10px;
            border-radius: 50px;
        }

        /* Chart & Courses sections */
        .two-col-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(168, 85, 247, 0.12);
            border-radius: 20px;
            padding: 1.75rem;
            backdrop-filter: blur(20px);
            animation: fadeUp 0.6s ease-out backwards;
        }

        .glass-panel:nth-child(1) { animation-delay: 0.35s; }
        .glass-panel:nth-child(2) { animation-delay: 0.45s; }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .panel-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #f3e8ff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(192, 132, 252, 0.1));
            border: 1px solid rgba(168, 85, 247, 0.2);
            font-size: 1rem;
        }

        .panel-badge {
            padding: 4px 12px;
            background: rgba(168, 85, 247, 0.12);
            border: 1px solid rgba(168, 85, 247, 0.2);
            border-radius: 50px;
            color: #c084fc;
            font-size: 0.78rem;
            font-weight: 600;
        }

        /* Course list */
        .course-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(168, 85, 247, 0.08);
            transition: all 0.3s ease;
        }

        .course-item:last-child { border-bottom: none; }

        .course-item:hover {
            padding-left: 8px;
        }

        .course-info {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
        }

        .course-rank {
            width: 32px; height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #c084fc;
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.15);
            flex-shrink: 0;
        }

        .course-details { min-width: 0; }

        .course-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #f3e8ff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .course-students {
            font-size: 0.8rem;
            color: rgba(216, 180, 254, 0.45);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .course-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #a3e635;
            flex-shrink: 0;
            margin-left: 1rem;
        }

        /* Canvas chart overrides */
        #coursesChart {
            max-height: 320px;
        }

        /* Scrollbar */
        .courses-scroll {
            max-height: 340px;
            overflow-y: auto;
        }

        .courses-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .courses-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .courses-scroll::-webkit-scrollbar-thumb {
            background: rgba(168, 85, 247, 0.2);
            border-radius: 10px;
        }

        /* Shimmer effect on hover for stat cards */
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(168, 85, 247, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .stat-card:hover::after {
            left: 100%;
        }

        /* Animated counter placeholder */
        .counter-anim {
            display: inline-block;
        }

        /* Footer note */
        .footer-note {
            text-align: center;
            color: rgba(216, 180, 254, 0.25);
            font-size: 0.78rem;
            padding: 2rem 0 1rem;
        }
    </style>

    <div class="instructor-dashboard">

        <!-- Animated BG -->
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
        <div class="bg-orb bg-orb-3"></div>
        <div class="grid-overlay"></div>

        <div class="dashboard-content">

            <!-- Header -->
            <div class="header-section">
                <div class="greeting-badge">
                    <span class="pulse-dot"></span>
                    Active now
                </div>
                <h1 class="header-title">
                    Welcome back, {{ auth()->user()->name }} 👋
                </h1>
                <p class="header-subtitle">
                    Here's what's happening with your courses today
                </p>
            </div>

            <!-- Stats -->
            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-glow"></div>
                    <div class="stat-icon-wrapper">📚</div>
                    <p class="stat-label">My Courses</p>
                    <p class="stat-value counter-anim" data-target="{{ $coursesCount }}">{{ $coursesCount }}</p>
                    <span class="stat-trend">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        Active
                    </span>
                </div>

                <div class="stat-card">
                    <div class="stat-glow"></div>
                    <div class="stat-icon-wrapper">👥</div>
                    <p class="stat-label">My Students</p>
                    <p class="stat-value counter-anim" data-target="{{ $studentsCount }}">{{ $studentsCount }}</p>
                    <span class="stat-trend">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        Growing
                    </span>
                </div>

                <div class="stat-card">
                    <div class="stat-glow"></div>
                    <div class="stat-icon-wrapper">💰</div>
                    <p class="stat-label">Total Revenue</p>
                    <p class="stat-value">$<span class="counter-anim" data-target="{{ $revenue }}">{{ $revenue }}</span></p>
                    <span class="stat-trend">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        Earning
                    </span>
                </div>

            </div>

            <!-- Chart + Latest Courses -->
            <div class="two-col-grid">

                <!-- Chart Panel -->
                <div class="glass-panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <span class="panel-title-icon">📊</span>
                            Courses Performance
                        </div>
                        <span class="panel-badge">This Month</span>
                    </div>
                    <canvas id="coursesChart"></canvas>
                </div>

                <!-- Latest Courses Panel -->
                <div class="glass-panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <span class="panel-title-icon">🆕</span>
                            Latest Courses
                        </div>
                        <span class="panel-badge">{{ count($latestCourses) }} courses</span>
                    </div>

                    <div class="courses-scroll">
                        @foreach($latestCourses as $index => $course)
                            <div class="course-item" style="animation: fadeUp 0.5s ease-out {{ 0.5 + ($index * 0.08) }}s backwards;">
                                <div class="course-info">
                                    <span class="course-rank">{{ $index + 1 }}</span>
                                    <div class="course-details">
                                        <p class="course-name">{{ $course->title }}</p>
                                        <p class="course-students">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                            {{ $course->students_number }} students
                                        </p>
                                    </div>
                                </div>
                                <span class="course-price">${{ $course->price }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="footer-note">
                Instructor Dashboard • Updated just now
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart
        const ctx = document.getElementById('coursesChart');

        const gradient = ctx.getContext('2d');
        const barGradient = gradient.createLinearGradient(0, 0, 0, 350);
        barGradient.addColorStop(0, 'rgba(168, 85, 247, 0.8)');
        barGradient.addColorStop(1, 'rgba(109, 40, 217, 0.2)');

        const hoverGradient = gradient.createLinearGradient(0, 0, 0, 350);
        hoverGradient.addColorStop(0, 'rgba(192, 132, 252, 0.95)');
        hoverGradient.addColorStop(1, 'rgba(139, 92, 246, 0.4)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Students per Course',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: barGradient,
                    hoverBackgroundColor: hoverGradient,
                    borderColor: 'rgba(168, 85, 247, 0.5)',
                    borderWidth: 1,
                    borderRadius: 12,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    categoryPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 16, 51, 0.95)',
                        titleColor: '#f3e8ff',
                        bodyColor: '#d8b4fe',
                        borderColor: 'rgba(168, 85, 247, 0.3)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 14,
                        titleFont: { size: 13, weight: '700', family: 'Inter' },
                        bodyFont: { size: 12, family: 'Inter' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '👥 ' + context.parsed.y + ' students';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(168, 85, 247, 0.06)',
                            drawBorder: false,
                        },
                        ticks: {
                            color: 'rgba(216, 180, 254, 0.4)',
                            font: { size: 12, family: 'Inter', weight: '500' },
                            padding: 8,
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: 'rgba(216, 180, 254, 0.5)',
                            font: { size: 11, family: 'Inter', weight: '500' },
                            maxRotation: 45,
                            padding: 8,
                        },
                        border: { display: false }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });

        // Counter animation
        document.querySelectorAll('.counter-anim').forEach(el => {
            const target = parseFloat(el.getAttribute('data-target'));
            if (isNaN(target)) return;

            const isDecimal = target % 1 !== 0;
            const duration = 1500;
            const startTime = performance.now();
            const startValue = 0;

            function animate(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Ease out quart
                const easeOut = 1 - Math.pow(1 - progress, 4);
                const current = startValue + (target - startValue) * easeOut;

                if (isDecimal) {
                    el.textContent = current.toFixed(2);
                } else {
                    el.textContent = Math.floor(current).toLocaleString();
                }

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    if (isDecimal) {
                        el.textContent = target.toFixed(2);
                    } else {
                        el.textContent = target.toLocaleString();
                    }
                }
            }

            // Start animation when visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        requestAnimationFrame(animate);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(el);
        });
    </script>

</x-app-layout>