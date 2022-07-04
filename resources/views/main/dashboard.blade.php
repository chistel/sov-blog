<x-layouts.main.authenticated>
    @section('seo')
        <title>Dashboard &raquo; {{ config('app.name') }}</title>
        <meta name="description" content="{{ config('app.name') }} Dashboard">
    @stop
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white md:text-primary leading-tight">
            Dashboard
        </h2>
    </x-slot>
    <div class="py-4 px-2 md:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap flex-row -mx-4">

                <div class="flex-shrink max-w-full px-4 w-full md:w-1/3">
                    <div class="rounded p-5 shadow-sm bg-white">
                        Still in progress
                    </div>
                </div>

                <div class="flex-shrink max-w-full px-4 w-full md:w-2/3">
                    @include('fragments.general._flash')

                    <div class="flex flex-row justify-end">
                        <a href="{{ route('main.articles.new') }}" class="focus:outline-none text-white text-sm sm:text-base bg-primary rounded py-1 px-4">
                            Add Bog
                        </a>
                    </div>


                    <div class="mt-4">
                        @if($articles->count())
                            <div class="flex flex-col gap-y-5">
                                @foreach($articles as $article)
                                    <div class="flex gap-x-4 p-3.5 rounded border bg-white">

                                        <div class="flex flex-col justify-center md:justify-start">
                                            <a href="{{ route('main.articles.single.view', ['article' => $article->uuid]) }}"
                                               class="font-medium text-base text-primary">
                                                {{ $article->title }}
                                            </a>
                                            <div class="my-1 text-sm">
                                                By <b>{{ $article->user->fullName }}</b>
                                            </div>
                                            <div class="w-full md:block my-1.5">
                                                <p class="text-sm break-words">
                                                    {{ getExcerpt($article->content, 200) }}
                                                </p>
                                            </div>
                                            <div class="flex justify-between">
                                                <div class="text-base font-normal text-gray-200">
                                                    <span>{{ $article->created_at->format('M d, Y') }}</span>
                                                </div>
                                                @if ($article->user_id == auth()->user()->id)
                                                    <div class="inline-flex space-x-6">
                                                        <a href="{{ route('main.articles.single.edit', ['article' => $article->uuid]) }}" class="text-primary">
                                                            Edit
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                           onclick="event.preventDefault(); document.getElementById('remove-article_{{ $article->uuid }}').submit();"
                                                           class="text-primary">
                                                            Delete
                                                        </a>
                                                    </div>

                                                    <form id="remove-article_{{ $article->uuid }}"
                                                          action="{{ route('main.articles.single.remove', ['article' => $article->uuid]) }}"
                                                          method="POST" class="hidden">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex space-x-6 my-2">
                                {{ $articles->links() }}
                            </div>
                        @else
                            None
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

</x-layouts.main.authenticated>
