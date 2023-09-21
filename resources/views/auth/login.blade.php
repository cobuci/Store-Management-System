<html lang="pt-br" >


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME') }}- Login</title>
    @livewireStyles
    <wireui:scripts/>
    @vite(['resources/css/app.css', "resources/js/theme.js"])

</head>

<body>

<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
        <div>
            <button class="dark-toogle dark:text-white">
                Dark mode
            </button>
        </div>
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                    @csrf
                    <div>
                        <x-input class="pr-28" label="Email" placeholder="your email" suffix="@mail.com" id="email"
                                 name="email"
                                 :value="old('email')"/>
                    </div>
                    <div>
                        <x-inputs.password label="Senha" placeholder="*******" id="password" name="password"/>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <x-checkbox id="right-label" label="Remeber me" id="remember_me" name="remember"/>
                            </div>
                        </div>
                    </div>
                    <x-button positive label="Sign in" type="submit" class="w-full rounded-lg "/>
                </form>
            </div>
        </div>
    </div>
</section>
@livewireScripts

</body>
</html>
