<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Blogs') }}
        </h2>
    </x-slot>
    <x-slot name="header2">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('blogs.create') }}">Create New Blog</a>
        </h2>
    </x-slot>
    @if ($blogs)
        <div class="py-12">
            @foreach ($blogs as $blog)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="border: 1px solid">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <a class="p-6" href="{{ route('blogs.edit', ['blog' => $blog->slug]) }}">Edit</a>
                        <form action="{{ route('blogs.destroy', ['blog' => $blog->slug]) }}" method="post">
                            @csrf @method('delete')
                            <input type="hidden" name="id" value="{{ $blog->id }}">
                            <button class="p-6 pb-0">Delete</button>
                        </form>
                        <div class="p-6 pb-0">
                            {{ $blog->title }}
                        </div>
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ $blog->content }}
                        </div>
                        <a class="p-6" href="{{ route('blogs.show', ['blog' => $blog->slug]) }}">Read more</a>
                    </div>
                </div>
            @endforeach
            {{ $blogs->links() }}
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="border: 1px solid">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <h2>You have not blogs!</h2> 
                    <a href="{{ route('blogs.create') }}">Create Blog Now!</a>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
