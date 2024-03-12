<x-app-layout>
    <x-slot name="header">
        @if(! auth()->user()->is_admin)
            <x-nav-link href="{{route('articles.index')}}">
                {{ __('My articles') }}
            </x-nav-link>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative rounded-xl overflow-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100 my-8">
                    @auth
                        <table class="border-collapse table-fixed w-full text-sm">
                            <thead>
                            <tr>
                                <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                    Title
                                </th>
                                <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                    Content
                                </th>
                                <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                    Author name
                                </th>
                                <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                    Publication date
                                </th>
                                <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                    Publication status
                                </th>
                                @if($article->author()->is(auth()->user()) || auth()->user()->is_admin)
                                    <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                        -
                                    </th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="dark:bg-slate-800 ">
                            <tr>
                                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->title}}</td>
                                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->content}}</td>
                                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->author->name}}</td>
                                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->publication_date->toDateString()}}</td>
                                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->publication_status->name}}</td>
                                <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                    @if($article->author()->is(auth()->user()))
                                        <x-responsive-nav-link href="{{route('articles.edit', $article->id)}}">edit
                                        </x-responsive-nav-link>
                                    @endif
                                    @if(auth()->user()->is_admin)
                                            @if($article->isDraft())
                                                <form action="{{route('article.publish', $article->id)}}" method="post">
                                                    @csrf
                                                    <x-secondary-button type="submit" class="mb-4">publish
                                                    </x-secondary-button>
                                                </form>
                                            @endif
                                            @if(is_null($article->deleted_at))
                                                <form action="{{route('articles.destroy', $article->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button class="mb-4">delete
                                                    </x-danger-button>
                                                </form>
                                            @else

                                                <form action="{{route('articles.restore', $article->id)}}" method="post">
                                                    @csrf
                                                    <x-secondary-button type="submit" class="mb-4">restore
                                                    </x-secondary-button>
                                                </form>
                                            @endif
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
