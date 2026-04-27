<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 p-4 sm:p-8">

        <div class="max-w-3xl mx-auto">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-purple-700 to-indigo-600 bg-clip-text text-transparent">
                    Notifications
                </h1>
                <p class="text-gray-400 text-sm mt-1">Stay updated with your latest alerts</p>
            </div>

            <!-- Notifications List -->
            <div class="space-y-3">
                @forelse($notifications as $notification)
                    <div class="relative bg-white/80 backdrop-blur-sm border rounded-2xl p-5 transition-all duration-500 hover:-translate-y-0.5
                        {{ $notification->read_at ? 'border-gray-100 hover:shadow-lg hover:shadow-gray-100/50' : 'border-purple-200/50 hover:shadow-xl hover:shadow-purple-100/50' }}">

                        <!-- Unread indicator -->
                        @if(!$notification->read_at)
                            <div class="absolute top-5 left-0 w-1 h-8 bg-gradient-to-b from-purple-500 to-indigo-500 rounded-r-full"></div>
                        @endif

                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center
                                {{ $notification->read_at ? 'bg-gray-100' : 'bg-gradient-to-br from-purple-100 to-indigo-100' }}">
                                @if($notification->read_at)
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="{{ $notification->read_at ? 'text-gray-500' : 'text-gray-800 font-medium' }} text-sm leading-relaxed">
                                    {{ $notification->data['message'] }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1.5">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <!-- Mark as Read -->
                            @if(!$notification->read_at)
                                <form method="POST" action="/notifications/{{ $notification->id }}/read" class="flex-shrink-0">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 text-purple-600 hover:text-purple-800 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-300">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Mark read
                                    </button>
                                </form>
                            @else
                                <span class="flex-shrink-0 text-xs text-gray-300 font-medium">Read</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white/60 rounded-2xl border border-purple-100/50">
                        <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        </div>
                        <p class="text-gray-400 font-medium">No notifications yet</p>
                        <p class="text-gray-300 text-sm mt-1">You're all caught up!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>