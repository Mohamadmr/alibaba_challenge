<x-app-layout>
    <x-slot name="header">
        <x-nav-link href="{{route('articles.index')}}">
            {{ __('My articles') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative rounded-xl overflow-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100 my-8">
                    @auth
                        <table class="border-collapse table-fixed w-full text-sm">
                            <thead>
                                <tr>
                                    <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">Title</th>
                                    <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">Content</th>
                                    <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">Author name</th>
                                    <th class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">-</th>
                                </tr>
                            </thead>
                            <tbody class="dark:bg-slate-800 ">
                            @foreach($articles as $article)
                                <tr>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->title}}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->content}}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{$article->author->name}}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"><x-responsive-nav-link href="{{route('articles.show', $article->id)}}">show
                                        </x-responsive-nav-link></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                        {{$articles->links()}}
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
