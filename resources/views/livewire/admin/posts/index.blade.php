<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
            <div class="sm:flex sm:items-center sm:justify-between pb-5 border-b border-gray-200">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold text-gray-900">Posts</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the posts in your account.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:flex-none">
                    <button wire:click="create()" type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        Add Post
                    </button>
                </div>
            </div>

            <!-- Session Messages -->
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <!-- Data Table -->
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 text-center">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 text-left">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Title</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Published At</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($posts as $post)
                                        <tr>
                                            <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $post->title }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $post->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'N/A' }}</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <button wire:click="edit({{ $post->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                <button wire:click="delete({{ $post->id }})" wire:confirm="Are you sure you want to delete this post?" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">No posts found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         <div class="mt-4">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Form -->
            @if($showModal)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        <form wire:submit.prevent="store">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $postId ? 'Edit Post' : 'Create Post' }}</h3>
                                <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input wire:model.lazy="title" type="text" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                        <input wire:model="slug" type="text" id="slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                        @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                                        <textarea wire:model.defer="content" id="content" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <select wire:model.defer="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="newImage" class="block text-sm font-medium text-gray-700">Featured Image</label>
                                        <input type="file" wire:model="newImage" id="newImage" class="mt-1">
                                        @if ($newImage)
                                            <img src="{{ $newImage->temporaryUrl() }}" class="mt-2 h-20 w-auto rounded">
                                        @elseif ($image)
                                            <img src="{{ asset('storage/' . $image) }}" class="mt-2 h-20 w-auto rounded">
                                        @endif
                                        @error('newImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                                <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>