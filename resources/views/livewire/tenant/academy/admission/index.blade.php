<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-header title="Demandes d'admission" separator>
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-funnel" />
            <x-button icon="o-plus" class="btn-primary" label="Créer une demande" link="/academy/admissions/create" />
        </x-slot:actions>
    </x-header>
    <!-- Card Section -->
    <div class="mx-auto">
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1486299267070-83823f5448dd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        London, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                    <p>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1612046264803-6d6b67fdee80?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        Bristol, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1582542021865-bde52fd7c3cf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        Oxford, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1571044880241-95d4c9aa06f5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        Edinburgh, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1598964356161-754cc07fcd36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        Newcastle, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1566328386401-b2980125f6c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        Liverpool, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->

            <!-- Card -->
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
                href="#">
                <div class="p-4 md:p-5">
                    <div class="flex justify-between items-center gap-x-3">
                        <div class="grow">
                            <div class="flex items-center gap-x-3">
                                <img class="size-[38px] rounded-full"
                                    src="https://images.unsplash.com/photo-1597740049284-388659a41286?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                                    alt="Avatar">
                                <div class="grow">
                                    <h3
                                        class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                        Manchester, UK
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                                        4 job positions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Section -->
</div>
