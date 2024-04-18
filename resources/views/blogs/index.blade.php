<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                    @if ($blogs)
                        <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                            <h2
                                class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                                Our Blog</h2>
                            <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">We use an agile approach to
                                test assumptions and connect with the needs of your audience early and often.</p>
                        </div>
                        <div class="grid gap-8 lg:grid-cols-2">
                            @foreach ($blogs as $blog)
                                <article
                                    class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                    <div class="flex justify-between items-center mb-5 text-gray-500">
                                        <span
                                            class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                            ID
                                            {{ $blog->id }}
                                        </span>
                                        @canany(['update', 'delete'], $blog)
                                            <a class="p-6"
                                                href="{{ route('blogs.edit', ['blog' => $blog->slug]) }}">Edit</a>
                                            <form action="{{ route('blogs.destroy', ['blog' => $blog->slug]) }}"
                                                method="post">
                                                @csrf @method('delete')
                                                <input type="hidden" name="id" value="{{ $blog->id }}">
                                                <button class="p-6 pb-0">Delete</button>
                                            </form>
                                        @endcanany
                                        <span
                                            class="text-sm">{{ now()->format('Y') * 365 + now()->format('m') * 30 + now()->format('d') - ($blog->created_at->format('Y') * 365 + $blog->created_at->format('m') * 30 + $blog->created_at->format('d')) }}
                                            days ago</span>
                                    </div>
                                    <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a
                                            href="{{ route('blogs.show', ['blog' => $blog->slug]) }}">{{ $blog->title }}</a>
                                    </h2>
                                    <p class="mb-5 font-light text-gray-500 dark:text-gray-400">{{ $blog->content }}</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center space-x-4">
                                            <img class="w-7 h-7 rounded-full" src="{{ asset('circle.png') }}"
                                                alt="{{ $blog->user->name }} avatar" />
                                            <span class="font-medium dark:text-white">
                                                {{ $blog->user->name }}
                                            </span>
                                        </div>
                                        <a href="{{ route('blogs.show', ['blog' => $blog->slug]) }}"
                                            class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                            Read more
                                            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        {{ $blogs->links() }}
                    @else
                        <h2>Error!</h2>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
