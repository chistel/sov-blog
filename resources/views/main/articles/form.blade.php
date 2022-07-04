<x-layouts.main.authenticated>
    @section('seo')
        <title>  {{ (isset($article) ? 'Edit article' : 'Create New Article') }} &raquo; {{ config('app.name') }}</title>
        <meta name="description" content="{{ config('app.name') }} {{ (isset($article) ? 'Edit article' : 'Create New Article') }}">
    @stop
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white md:text-primary leading-tight">
            {{ (isset($article) ? 'Edit article' : 'Create New Article') }}
        </h2>
        @if (isset($article))
            <div class="mt-1 text-sm">
                {{ $article->title }}
            </div>
        @endif
    </x-slot>
    <div class="py-4 px-2 md:px-0">
        <div class="relative max-w-full md:max-w-5xl w-full mx-auto sm:px-6 lg:px-20">
            @include('fragments.general._flash')

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ $actionUrl }}" method="post">
                    @csrf
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:space-x-4 mb-4">

                            <div class="w-full">
                                <label for="title" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">
                                    Title
                                </label>
                                <input
                                    id="title"
                                    type="text"
                                    name="title"
                                    value="{{ (isset($article) ? $article->title : '') }}"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300"
                                    placeholder="Title"
                                />
                                <x-form.input-error for="title" class="mt-2"/>
                            </div>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label
                                for="article_content"
                                class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600"
                            >Content</label>
                            <div class="mt-1">
                                {{--<textarea name="body" id="article_content"
                                     class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-b-md"
                                ></textarea>--}}
                                <div id="article_content" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-b-md"
                                >
                                    {{ (isset($article) ? $article->content : '') }}
                                </div>
                                <textarea class="hidden" id="hidden_body" name="body">{{ (isset($article) ? $article->body : '') }}</textarea>
                            </div>
                            <x-form.input-error for="body" class="mt-2"/>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        <x-form.primary-button>

                            {{ (isset($article) ? 'Update' : 'Save') }}
                        </x-form.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script type="text/javascript">
            const options = {
                modules: {
                    toolbar: [
                        ['bold', 'italic'],
                        ['link', 'blockquote', 'code-block', 'image'],
                        [{list: 'ordered'}, {list: 'bullet'}]
                    ]
                },
                placeholder: 'Article content',
                theme: 'snow'
            };
            const editor = new Quill('#article_content', options);
            editor.on('text-change', function (delta, oldDelta, source) {
                document.getElementById("hidden_body").value = editor.root.innerHTML;
            });
        </script>
    @endpush
</x-layouts.main.authenticated>
