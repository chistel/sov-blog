<x-layouts.main.authenticated>
    @section('seo')
        <title> {{ $article->title }} &raquo; {{ config('app.name') }}</title>
        <meta name="description" content="{{ config('app.name') }} {{ $article->title }}">
    @stop
    {{-- <x-slot name="header">
         <h2 class="font-semibold text-xl text-white md:text-primary leading-tight">
             Dashboard
         </h2>
     </x-slot>--}}
    <div class="py-4 px-2 md:px-0">
        <div class="relative max-w-full md:max-w-7xl w-full mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-row gap-x-12">
                <div class="w-full md:w-2/3 bg-white p-4 rounded">
                    <div class="flex flex-col gap-x-4">
                        <div>
                            <h1 class="text-2xl">
                                {{ $article->title }}
                            </h1>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-base flex items-center mb-3.5 font-normal">
                                {{ $article->created_at->format('M d, Y') }}
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

                    <div class="border-t mb-1">
                        <div class="text-lg article-content">
                            {!! $article->content !!}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.main.authenticated>
