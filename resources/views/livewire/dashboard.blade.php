<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{ activeTab: 'calendar' }">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Content Dashboard</h1>
            <p class="text-sm text-gray-500">Manage and monitor your scheduled content</p>
        </div>

        <!-- View Toggle -->
        <div class="flex rounded-md shadow-sm">
            <button @click="activeTab = 'calendar'"
                    :class="{ 'bg-blue-600 text-white': activeTab === 'calendar', 'bg-white text-gray-700': activeTab !== 'calendar' }"
                    class="px-4 py-2 text-sm font-medium rounded-l-md border border-gray-300 focus:z-10 focus:outline-none">
                <i class="fas fa-calendar-alt mr-2"></i> Calendar
            </button>
            <button @click="activeTab = 'list'"
                    :class="{ 'bg-blue-600 text-white': activeTab === 'list', 'bg-white text-gray-700': activeTab !== 'list' }"
                    class="px-4 py-2 text-sm font-medium rounded-r-md border border-gray-300 focus:z-10 focus:outline-none">
                <i class="fas fa-list mr-2"></i> List View
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Posts</p>
                    <p class="text-2xl font-semibold">{{ $stats['total'] }}</p>
                </div>
                <i class="fas fa-newspaper text-blue-500 text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Scheduled</p>
                    <p class="text-2xl font-semibold text-yellow-600">{{ $stats['scheduled'] }}</p>
                </div>
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Published</p>
                    <p class="text-2xl font-semibold text-green-600">{{ $stats['published'] }}</p>
                </div>
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Drafts</p>
                    <p class="text-2xl font-semibold text-gray-600">{{ $stats['drafts'] }}</p>
                </div>
                <i class="fas fa-edit text-gray-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="draft">Draft</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                <select wire:model.live="platformFilter"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Platforms</option>
                    @foreach($platforms as $platform)
                        <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" wire:model.live="dateFilter"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex items-end">
                <button wire:click="$set('statusFilter', '')"
                        wire:loading.attr="disabled"
                        class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div x-show="activeTab === 'calendar'" x-transition>
        <div class="bg-white p-4 rounded-lg shadow">
            <div wire:ignore>
                <div id="calendar" class="min-h-[600px]"></div>
            </div>
        </div>
    </div>

    <!-- List View -->
    <div x-show="activeTab === 'list'" x-transition>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platforms</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($posts as $post)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $post->title }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($post->content, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-gray-100 text-gray-800' => $post->status === 'draft',
                                        'bg-yellow-100 text-yellow-800' => $post->status === 'scheduled',
                                        'bg-green-100 text-green-800' => $post->status === 'published',
                                    ])>
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($post->platforms as $platform)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $platform->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $post->scheduled_time->format('M j, Y g:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No posts found matching your criteria
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    <!-- Post Preview Modal -->
    <div x-data="{ showPreview: false, previewPost: null }"
         x-on:show-post.window="showPreview = true; previewPost = $event.detail">
        <div x-show="showPreview" x-transition class="fixed inset-0 z-50 overflow-y-auto">
            <!-- Modal content -->
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/list/main.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://unpkg.com/@fullcalendar/core@5.11.3/main.global.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/daygrid@5.11.3/main.global.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/interaction@5.11.3/main.global.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/list@5.11.3/main.global.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
});
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    console.log('calendarEl:', calendarEl);

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: @json($this->calendarEvents),
        eventClick: function(info) {
            window.Livewire.emit('showPost', info.event.extendedProps);
        },
        eventDidMount: function(info) {
            const platformIcons = info.event.extendedProps.platforms.map(p =>
                `<span class="inline-block w-3 h-3 rounded-full mr-1"
                      style="background-color: ${getPlatformColor(p.name)}"></span>`
            ).join('');

            const eventEl = info.el;
            eventEl.querySelector('.fc-event-title').insertAdjacentHTML('afterend', platformIcons);
        }
    });
    calendar.render();
console.log('Calendar initialized with events:', @json($this->calendarEvents));

    Livewire.hook('message.processed', () => {
        calendar.refetchEvents();
    });

    function getPlatformColor(platformName) {
        const colors = {
            'Twitter': '#1DA1F2',
            'Facebook': '#4267B2',
            'Instagram': '#E1306C',
            'LinkedIn': '#0077B5'
        };
        return colors[platformName] || '#6B7280';
    }

    Livewire.on('refreshCalendar', () => {
        calendar.refetchEvents();
    });
});
</script>
@endpush
