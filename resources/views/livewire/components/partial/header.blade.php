<div
    class="flex flex-col fixed top-0 left-0 right-0 z-50 mx-auto max-w-sm p-4 bg-slate-100 gap-4"
    @click.away="$wire.close()"
>
    <div class="flex items-center justify-between">
        <div class="w-8/12">
            <div class="flex flex-row items-center space-x-2">
                <img
                    src="https://avatar.iran.liara.run/public/52"
                    alt="avatar"
                    class="size-10"
                />
                <div class="flex flex-col w-full">
                    @auth
                    <div class="text-xs font-light text-sky-900">Haii</div>
                    <div class="text-sm font-bold text-sky-900">
                        {{ Auth::user()->name }}
                    </div>
                    @else
                    <div class="text-xs font-light text-sky-900">Haii</div>
                    <div class="text-sm font-bold text-sky-900">Guest</div>
                    @endauth
                </div>
            </div>
        </div>
        <div
            class="w-4/12 text-end justify-end space-x-2 flex flex-row items-center"
        >
            <div class="p-2 rounded-full bg-sky-100">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="size-6 text-sky-700"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>

            <button
                class="p-2 bg-sky-100 rounded-full cursor-pointer"
                x-on:click="$wire.toggle()"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    :class="($wire.showMenu ? 'text-rose-700' : 'text-sky-700') + ' size-6'"
                >
                    <path
                        wire:show="!showMenu"
                        x-transition.duration.100ms
                        d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm8.25 5.25a.75.75 0 0 1 .75-.75h8.25a.75.75 0 0 1 0 1.5H12a.75.75 0 0 1-.75-.75Z"
                        clip-rule="evenodd"
                    />

                    <path
                        wire:show="showMenu"
                        x-transition.duration.100ms
                        fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
        </div>
    </div>
    <div
        wire:show="showMenu"
        x-transition.duration.100ms
        class="max-w-sm mx-auto w-full flex flex-col justify-between space-y-1.5"
    >
        <a
            href="#"
            class="w-full rounded-md text-slate-700 text-sm font-semibold p-2 bg-slate-200"
            >Lorem ipsum dolor</a
        >
        <a
            href="#"
            class="w-full rounded-md text-slate-700 text-sm font-semibold bg-slate-200 p-2"
            >Lorem ipsum dolor</a
        >
        <a
            href="#"
            class="w-full rounded-md text-slate-700 text-sm font-semibold bg-slate-200 p-2"
            >Lorem ipsum dolor</a
        >
        <div class="relative flex py-4 items-center">
            <div class="flex-grow border-t border-sky-400"></div>
            <span class="flex-shrink mx-4 text-sky-700 text-xs font-semibold"
                >PAGUYUBAN</span
            >
            <div class="flex-grow border-t border-sky-400"></div>
        </div>
        @guest
        <a
            href="http://127.0.0.1:8000/admin/login"
            class="text-center w-full p-2 rounded-md bg-lime-700 text-slate-100 text-xs font-medium"
            >Login</a
        >
        <a
            href="http://127.0.0.1:8000/admin/register"
            class="text-center w-full p-2 rounded-md bg-sky-700 text-slate-50 text-xs font-medium"
            >Register</a
        >
        @endguest @auth
        <p
            class="text-center w-full p-2 rounded-md bg-lime-700 text-slate-100 text-xs font-medium"
        >
            Welcome, {{ Auth::user()->name }}!
        </p>
        <!-- <button
            class="text-center w-full p-2 rounded-md bg-sky-700 text-slate-50 text-xs font-medium cursor-pointer"
            wire:click="logout"
        >
            Logout
        </button> -->
        @endauth
    </div>
</div>
