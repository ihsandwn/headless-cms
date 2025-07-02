<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold leading-tight text-slate-900">
                Good morning, {{ Auth::user()->name }}
            </h1>
            <p class="mt-2 text-lg text-slate-600">
                Here's a quick overview of your content.
            </p>
        </div>
        
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Posts Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl transform hover:-translate-y-1 transition-transform duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <!-- Heroicon: newspaper -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Posts</dt>
                                <dd>
                                    <div class="text-2xl font-bold text-gray-900">{{ $postCount }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4">
                    <div class="text-sm">
                        <a href="{{ route('admin.posts.index') }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                            Manage Posts &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pages Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl transform hover:-translate-y-1 transition-transform duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <!-- Heroicon: document-text -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Pages</dt>
                                <dd>
                                    <div class="text-2xl font-bold text-gray-900">{{ $pageCount }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4">
                    <div class="text-sm">
                        <a href="{{ route('admin.pages.index') }}" class="font-medium text-green-600 hover:text-green-800">
                            Manage Pages &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl transform hover:-translate-y-1 transition-transform duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-amber-500 rounded-md p-3">
                            <!-- Heroicon: tag -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 8V3z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Categories</dt>
                                <dd>
                                    <div class="text-2xl font-bold text-gray-900">{{ $categoryCount }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4">
                    <div class="text-sm">
                        <a href="{{ route('admin.categories.index') }}" class="font-medium text-amber-600 hover:text-amber-800">
                            Manage Categories &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>