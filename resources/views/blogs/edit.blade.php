<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Blog') }}
        </h2>
    </x-slot>
    <style>
        .fflex {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 fflex">
                    <form action="{{ route('blogs.update', ['blog' => $blog->slug]) }}" method="POST"
                        class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col w-full mt-10 md:mt-0 relative z-10">
                        @csrf @method('put')
                        <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Edit Blog</h2>
                        <p class="leading-relaxed mb-5 text-gray-600">You can ediy blog here!</p>
                        <div class="relative mb-4">
                            <label for="title" class="leading-7 text-sm text-gray-600">Title</label>
                            <input type="text" value="{{ $blog->title }}" id="title" name="title" required
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="content" class="leading-7 text-sm text-gray-600">Content</label>
                            <textarea id="content" name="content" required
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $blog->content }}</textarea>
                        </div>
                        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                        <button
                            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
