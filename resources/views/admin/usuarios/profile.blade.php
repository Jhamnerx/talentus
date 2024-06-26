@extends('layouts.admin')

@section('contenido')
    <div class="relative flex">
        <div id="profile-sidebar"
            class="absolute z-20 top-0 bottom-0 w-full md:w-auto md:static md:top-auto md:bottom-auto -mr-px md:translate-x-0 transform transition-transform duration-200 ease-in-out"
            :class="profileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div
                class="sticky top-16 bg-white overflow-x-hidden overflow-y-auto no-scrollbar shrink-0 border-r border-slate-200 md:w-72 xl:w-80 h-[calc(100vh-64px)]">

                <!-- Profile group -->
                <div>
                    <!-- Group header -->
                    <div class="sticky top-0 z-10">
                        <div class="flex items-center bg-white border-b border-slate-200 px-5 h-16">
                            <div class="w-full flex items-center justify-between">
                                <!-- Profile image -->
                                <div class="relative">
                                    <div class="grow flex items-center truncate">
                                        <img class="w-8 h-8 rounded-full mr-2" src="{{ $user->profile_photo_url }}"
                                            width="32" height="32" alt="Group 01" />
                                        <div class="truncate">
                                            <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add button -->
                                <a href="{{ route('admin.users.create') }}">
                                    <button
                                        class="p-1.5 shrink-0 rounded border border-slate-200 hover:border-slate-300 shadow-sm ml-2">
                                        <svg class="w-4 h-4 fill-current text-indigo-500" viewBox="0 0 16 16">
                                            <path
                                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1Z" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Group body -->
                    <div class="px-5 py-4">
                        <!-- Search form -->
                        <form class="relative">
                            <label for="profile-search" class="sr-only">Buscar</label>
                            <input id="profile-search" class="form-input w-full pl-9 focus:border-slate-300" type="search"
                                placeholder="Search…" />
                            <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                                <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                                    viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                    <path
                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                                </svg>
                            </button>
                        </form>
                        <!-- Team members -->
                        <div class="mt-4">
                            <div class="text-xs font-semibold text-slate-400 uppercase mb-3">Equipo de Trabajo</div>
                            <ul class="mb-6">
                                <li class="-mx-2">
                                    <button class="w-full p-2 rounded bg-indigo-100" @click="profileSidebarOpen = false">
                                        <div class="flex items-center">
                                            <div class="relative mr-2">
                                                <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}"
                                                    width="32" height="32" alt="User 08" />
                                            </div>
                                            <div class="truncate">
                                                <span class="text-sm font-medium text-slate-800">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- PROFILE BODY --}}
        {{-- <div class="bg-white grow flex flex-col md:translate-x-0 transform transition-transform duration-300 ease-in-out"
            :class="profileSidebarOpen ? 'translate-x-1/3' : 'translate-x-0'">

            <!-- Profile background -->
            <div class="relative h-56 bg-slate-200">
                <img class="object-cover h-full w-full" src="{{ $user->profile_photo_url }}" width="979" height="220"
                    alt="Profile background" />
                <!-- Close button -->
                <button class="md:hidden absolute top-4 left-4 sm:left-6 text-white opacity-80 hover:opacity-100"
                    @click.stop="profileSidebarOpen = !profileSidebarOpen" aria-controls="profile-sidebar"
                    :aria-expanded="profileSidebarOpen">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="relative px-4 sm:px-6 pb-8">

                <!-- Pre-header -->
                <div class="-mt-16 mb-6 sm:mb-3">

                    <div class="flex flex-col items-center sm:flex-row sm:justify-between sm:items-end">

                        <!-- Avatar -->
                        <div class="inline-flex -ml-1 -mt-1 mb-4 sm:mb-0">
                            <img class="rounded-full border-4 border-white" src="{{ $user->profile_photo_url }}"
                                width="128" height="128" alt="Avatar" />
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2 sm:mb-2">
                            <button class="p-1.5 shrink-0 rounded border border-slate-200 hover:border-slate-300 shadow-sm">
                                <svg class="w-4 h-1 fill-current text-slate-400" viewBox="0 0 16 4">
                                    <circle cx="8" cy="2" r="2" />
                                    <circle cx="2" cy="2" r="2" />
                                    <circle cx="14" cy="2" r="2" />
                                </svg>
                            </button>
                            <button class="p-1.5 shrink-0 rounded border border-slate-200 hover:border-slate-300 shadow-sm">
                                <svg class="w-4 h-4 fill-current text-indigo-500" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7Zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8Z" />
                                </svg>
                            </button>
                            <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                                <svg class="fill-current shrink-0" width="11" height="8" viewBox="0 0 11 8">
                                    <path d="m.457 4.516.969-.99 2.516 2.481L9.266.702l.985.99-6.309 6.284z" />
                                </svg>
                                <span class="ml-2">Siguiendo</span>
                            </button>
                        </div>

                    </div>

                </div>

                <!-- Header -->
                <header class="text-center sm:text-left mb-6">
                    <!-- Name -->
                    <div class="inline-flex items-start mb-2">
                        <h1 class="text-2xl text-slate-800 font-bold">{{ $user->name }}</h1>
                        <svg class="w-4 h-4 fill-current shrink-0 text-yellow-500 ml-2" viewBox="0 0 16 16">
                            <path
                                d="M13 6a.75.75 0 0 1-.75-.75 1.5 1.5 0 0 0-1.5-1.5.75.75 0 1 1 0-1.5 1.5 1.5 0 0 0 1.5-1.5.75.75 0 1 1 1.5 0 1.5 1.5 0 0 0 1.5 1.5.75.75 0 1 1 0 1.5 1.5 1.5 0 0 0-1.5 1.5A.75.75 0 0 1 13 6ZM6 16a1 1 0 0 1-1-1 4 4 0 0 0-4-4 1 1 0 0 1 0-2 4 4 0 0 0 4-4 1 1 0 1 1 2 0 4 4 0 0 0 4 4 1 1 0 0 1 0 2 4 4 0 0 0-4 4 1 1 0 0 1-1 1Z" />
                        </svg>
                    </div>
                    <!-- Bio -->
                    <div class="text-sm mb-3">Fitness Fanatic, Design Enthusiast, Mentor, Meetup Organizer & PHP Lover.
                    </div>
                    <!-- Meta -->
                    <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 fill-current shrink-0 text-slate-400" viewBox="0 0 16 16">
                                <path
                                    d="M8 8.992a2 2 0 1 1-.002-3.998A2 2 0 0 1 8 8.992Zm-.7 6.694c-.1-.1-4.2-3.696-4.2-3.796C1.7 10.69 1 8.892 1 6.994 1 3.097 4.1 0 8 0s7 3.097 7 6.994c0 1.898-.7 3.697-2.1 4.996-.1.1-4.1 3.696-4.2 3.796-.4.3-1 .3-1.4-.1Zm-2.7-4.995L8 13.688l3.4-2.997c1-1 1.6-2.198 1.6-3.597 0-2.798-2.2-4.996-5-4.996S3 4.196 3 6.994c0 1.399.6 2.698 1.6 3.697 0-.1 0-.1 0 0Z" />
                            </svg>
                            <span
                                class="text-sm font-medium whitespace-nowrap text-slate-500 ml-2">{{ $user->direccion }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 fill-current shrink-0 text-slate-400" viewBox="0 0 16 16">
                                <path
                                    d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0ZM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12Zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2Z" />
                            </svg>
                            <a class="text-sm font-medium whitespace-nowrap text-indigo-500 hover:text-indigo-600 ml-2"
                                href="#0">{{ $user->email }}</a>
                        </div>
                    </div>
                </header>

                <!-- Tabs -->
                <div class="relative mb-6">
                    <div class="absolute bottom-0 w-full h-px bg-slate-200" aria-hidden="true"></div>
                    <ul
                        class="relative text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
                        <li
                            class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <a class="block pb-3 text-indigo-500 whitespace-nowrap border-b-2 border-indigo-500"
                                href="#0">General</a>
                        </li>
                        <li
                            class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap"
                                href="#0">Conexiones</a>
                        </li>
                        <li
                            class="mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                            <a class="block pb-3 text-slate-500 hover:text-slate-600 whitespace-nowrap"
                                href="#0">Contribuciones</a>
                        </li>
                    </ul>
                </div>

                <!-- Profile content -->
                <div class="flex flex-col xl:flex-row xl:space-x-16">

                    <!-- Main content -->
                    <div class="space-y-5 mb-8 xl:mb-0">

                        <!-- About Me -->
                        <div>
                            <h2 class="text-slate-800 font-semibold mb-2">Info</h2>
                            <div class="text-sm space-y-2">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                <p>Consectetur adipiscing elit, sed do eiusmod tempor magna aliqua.</p>
                            </div>
                        </div>

                        <!-- Departments -->
                        <div>
                            <h2 class="text-slate-800 font-semibold mb-2">Areas</h2>
                            <!-- Cards -->
                            <div class="grid xl:grid-cols-2 gap-4">

                                <!-- Card -->
                                <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm">
                                    <!-- Card header -->
                                    <div class="grow flex items-center truncate mb-2">
                                        <div
                                            class="w-8 h-8 shrink-0 flex items-center justify-center bg-slate-700 rounded-full mr-2">
                                            <img class="ml-1" src="../images/icon-03.svg" width="14"
                                                height="14" alt="Icon 03" />
                                        </div>
                                        <div class="truncate">
                                            <span class="text-sm font-medium text-slate-800">Administracion</span>
                                        </div>
                                    </div>
                                    <!-- Card content -->
                                    <div class="text-sm mb-3">Duis aute irure dolor in reprehenderit in voluptate velit
                                        esse cillum dolore.</div>
                                    <!-- Card footer -->
                                    <div class="flex justify-between items-center">
                                        <!-- Avatars group -->
                                        <div class="flex -space-x-3 -ml-0.5">
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                        </div>
                                        <!-- Link -->
                                        <div>
                                            <a class="text-sm font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">Ver -&gt;</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card -->
                                <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm">
                                    <!-- Card header -->
                                    <div class="grow flex items-center truncate mb-2">
                                        <div
                                            class="w-8 h-8 shrink-0 flex items-center justify-center bg-slate-700 rounded-full mr-2">
                                            <img class="ml-1" src="../images/icon-02.svg" width="14"
                                                height="14" alt="Icon 02" />
                                        </div>
                                        <div class="truncate">
                                            <span class="text-sm font-medium text-slate-800">Ventas</span>
                                        </div>
                                    </div>
                                    <!-- Card content -->
                                    <div class="text-sm mb-3">Duis aute irure dolor in reprehenderit in voluptate velit
                                        esse cillum dolore.</div>
                                    <!-- Card footer -->
                                    <div class="flex justify-between items-center">
                                        <!-- Avatars group -->
                                        <div class="flex -space-x-3 -ml-0.5">
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                            <img class="rounded-full border-2 border-white box-content"
                                                src="{{ $user->profile_photo_url }}" width="24" height="24"
                                                alt="Avatar" />
                                        </div>
                                        <!-- Link -->
                                        <div>
                                            <a class="text-sm font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">Ver -&gt;</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Work History -->
                        <div>
                            <h2 class="text-slate-800 font-semibold mb-2">Historial de Trabajo</h2>
                            <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm">
                                <ul class="space-y-3">

                                    <!-- Item -->
                                    <li class="sm:flex sm:items-center sm:justify-between">
                                        <div class="sm:grow flex items-center text-sm">
                                            <!-- Icon -->
                                            <div class="w-8 h-8 rounded-full shrink-0 bg-yellow-500 my-2 mr-3">
                                                <svg class="w-8 h-8 fill-current text-yellow-50" viewBox="0 0 32 32">
                                                    <path
                                                        d="M21 14a.75.75 0 0 1-.75-.75 1.5 1.5 0 0 0-1.5-1.5.75.75 0 1 1 0-1.5 1.5 1.5 0 0 0 1.5-1.5.75.75 0 1 1 1.5 0 1.5 1.5 0 0 0 1.5 1.5.75.75 0 1 1 0 1.5 1.5 1.5 0 0 0-1.5 1.5.75.75 0 0 1-.75.75Zm-7 10a1 1 0 0 1-1-1 4 4 0 0 0-4-4 1 1 0 0 1 0-2 4 4 0 0 0 4-4 1 1 0 0 1 2 0 4 4 0 0 0 4 4 1 1 0 0 1 0 2 4 4 0 0 0-4 4 1 1 0 0 1-1 1Z" />
                                                </svg>
                                            </div>
                                            <!-- Position -->
                                            <div>
                                                <div class="font-medium text-slate-800">Senior Product Designer</div>
                                                <div class="flex flex-nowrap items-center space-x-2 whitespace-nowrap">
                                                    <div>Remote</div>
                                                    <div class="text-slate-400">·</div>
                                                    <div>April, 2020 - Today</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tags -->
                                        <div class="sm:ml-2 mt-2 sm:mt-0">
                                            <ul class="flex flex-wrap sm:justify-end -m-1">
                                                <li class="m-1">
                                                    <button
                                                        class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Marketing</button>
                                                </li>
                                                <li class="m-1">
                                                    <button
                                                        class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">+4</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- Item -->
                                    <li class="sm:flex sm:items-center sm:justify-between">
                                        <div class="sm:grow flex items-center text-sm">
                                            <!-- Icon -->
                                            <div class="w-8 h-8 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                                                <svg class="w-8 h-8 fill-current text-indigo-50" viewBox="0 0 32 32">
                                                    <path
                                                        d="M8.994 20.006a1 1 0 0 1-.707-1.707l4.5-4.5a1 1 0 0 1 1.414 0l3.293 3.293 4.793-4.793a1 1 0 1 1 1.414 1.414l-5.5 5.5a1 1 0 0 1-1.414 0l-3.293-3.293L9.7 19.713a1 1 0 0 1-.707.293Z" />
                                                </svg>
                                            </div>
                                            <!-- Position -->
                                            <div>
                                                <div class="font-medium text-slate-800">Product Designer</div>
                                                <div class="flex flex-nowrap items-center space-x-2 whitespace-nowrap">
                                                    <div>Milan, IT</div>
                                                    <div class="text-slate-400">·</div>
                                                    <div>April, 2018 - April 2020</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tags -->
                                        <div class="sm:ml-2 mt-2 sm:mt-0">
                                            <ul class="flex flex-wrap sm:justify-end -m-1">
                                                <li class="m-1">
                                                    <button
                                                        class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Marketing</button>
                                                </li>
                                                <li class="m-1">
                                                    <button
                                                        class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">+4</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- Item -->
                                    <li class="sm:flex sm:items-center sm:justify-between">
                                        <div class="sm:grow flex items-center text-sm">
                                            <!-- Icon -->
                                            <div class="w-8 h-8 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                                                <svg class="w-8 h-8 fill-current text-indigo-50" viewBox="0 0 32 32">
                                                    <path
                                                        d="M8.994 20.006a1 1 0 0 1-.707-1.707l4.5-4.5a1 1 0 0 1 1.414 0l3.293 3.293 4.793-4.793a1 1 0 1 1 1.414 1.414l-5.5 5.5a1 1 0 0 1-1.414 0l-3.293-3.293L9.7 19.713a1 1 0 0 1-.707.293Z" />
                                                </svg>
                                            </div>
                                            <!-- Position -->
                                            <div>
                                                <div class="font-medium text-slate-800">Product Designer</div>
                                                <div class="flex flex-nowrap items-center space-x-2 whitespace-nowrap">
                                                    <div>Milan, IT</div>
                                                    <div class="text-slate-400">·</div>
                                                    <div>April, 2018 - April 2020</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tags -->
                                        <div class="sm:ml-2 mt-2 sm:mt-0">
                                            <ul class="flex flex-wrap sm:justify-end -m-1">
                                                <li class="m-1">
                                                    <button
                                                        class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">Marketing</button>
                                                </li>
                                                <li class="m-1">
                                                    <button
                                                        class="inline-flex items-center justify-center text-xs font-medium leading-5 rounded-full px-2.5 py-0.5 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">+4</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar -->
                    <aside class="xl:min-w-56 xl:w-56 space-y-3">
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Rol</h3>
                            <div>
                                @foreach ($user->roles as $rol)
                                    {{ $rol->name }}
                                @endforeach
                            </div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Ubicación</h3>
                            <div>{{ $user->direccion }} - Remote</div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Email</h3>
                            <div>{{ $user->email }}</div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Cumpleaños</h3>
                            <div>{{ $user->birthday ? $user->birthday->format('d F, Y') : '' }}</div>
                        </div>
                        <div class="text-sm">
                            <h3 class="font-medium text-slate-800">Inicio Laboral</h3>
                            <div>{{ $user->created_at->format('d F, Y') }}</div>
                        </div>
                    </aside>

                </div>

            </div>

        </div> --}}
    </div>
@stop

@section('js')





@stop
