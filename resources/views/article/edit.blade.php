<x-app-layout>
    <x-slot name="header">
        <x-nav-link href="{{route('articles.index')}}">
            {{ __('My articles') }}
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative rounded-xl overflow-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100 my-8">
                    @if($errors->any())
                        @foreach($errors->messages() as $message)
                            <div>{{implode("\n", $message)}}</div>
                            <br>
                        @endforeach
                        <br>
                    @endif
                    @auth
                        <form action="{{route('articles.update', $article->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="flex">
                                <x-text-input value="{{$article->title}}" class="mr-2" name="title" placeholder="title"
                                              type="text"></x-text-input>
                                <x-text-input value="{{$article->content}}" class="mr-2" name="content"
                                              placeholder="content"
                                              type="text"></x-text-input>
                                <x-text-input value="{{$article->publication_date->toDateString()}}" class="mr-2"
                                              name="publication_date" type="date"></x-text-input>
                            </div>

                            <br>
                            <x-primary-button class="mt-3">submit</x-primary-button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const dateControl = document.querySelector('input[type="date"]');
    dateControl.innerText = String.prototype.replace('/', '-');
</script>
