<template>
    <header class="h-14 flex-none flex items-center bg-white shadow-sm relative">
        <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
            <div class="flex items-center">
                <div class="flex-auto">
                    <h3 class="text-lg pl-10 xl:pl-0">{{ title }}</h3>
                </div>
                <div class="flex-none flex items-center space-x-4">
                    <button
                        class="px-4 py-1.5 flex items-center space-x-1 text-gray-800 rounded-xl hover:text-gray-900 hover:bg-gray-100"
                        @click="togglePrompt(true)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                        </svg>

                        <span>指令大全</span>
                    </button>

                    <Menu as="div" class="relative inline-block">
                        <MenuButton v-if="userInfo" class="w-8 h-8 p-px rounded-full border-2 border-transparent hover:border-gray-100 focus:border-gray-100">
                            <img class="w-full h-full rounded-full" :src="userInfo.avatar" :alt="userInfo.name">
                        </MenuButton>

                        <!-- Dropdown -->
                        <Transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="opacity-0 scale-90"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-90"
                        >
                            <MenuItems class="absolute right-0 origin-top-right z-10 mt-2 w-48 shadow-lg rounded-xl focus:outline-none dark:shadow-gray-900">
                                <div class="bg-white ring-1 ring-gray-200 ring-opacity-25 rounded-xl divide-y divide-gray-50 dark:bg-gray-800 dark:divide-gray-700 dark:ring-gray-700">
                                    <div class="p-2 space-y-1">
                                        <MenuItem v-slot="{ active }">
                                            <a
                                                href="#"
                                                class="group font-medium flex items-center justify-between space-x-2 px-2.5 py-1.5 rounded-lg border border-transparent"
                                                :class="{
                    'text-gray-800 bg-gray-100': active,
                    'text-gray-800 hover:text-gray-800 hover:bg-gray-100 active:border-gray-50': !active,
                  }"
                                            >
                                                <svg class="flex-none hi-mini hi-user-circle inline-block w-5 h-5 opacity-25 group-hover:opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd"/></svg>
                                                <span class="grow">个人中心</span>
                                            </a>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <a
                                                href="#"
                                                class="group font-medium flex items-center justify-between space-x-2 px-2.5 py-1.5 rounded-lg border border-transparent"
                                                :class="{
                    'text-gray-800 bg-gray-100': active,
                    'text-gray-800 hover:text-gray-800 hover:bg-gray-100 active:border-gray-50': !active,
                  }"
                                            >
                                                <svg class="flex-none hi-mini hi-cog-6-tooth inline-block w-5 h-5 opacity-25 group-hover:opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                                                <span class="grow">我的设置</span>
                                            </a>
                                        </MenuItem>
                                    </div>
                                    <div class="p-2 space-y-1">
                                        <MenuItem v-slot="{ active }">
                                            <a
                                                href="#"
                                                class="group font-medium flex items-center justify-between space-x-2 px-2.5 py-1.5 rounded-lg border border-transparent"
                                                :class="{
                    'text-gray-800 bg-gray-100': active,
                    'text-gray-800 hover:text-gray-800 hover:bg-gray-100 active:border-gray-50': !active,
                  }"
                                            >
                                                <svg class="flex-none hi-mini hi-lock-closed inline-block w-5 h-5 opacity-25 group-hover:opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/></svg>
                                                <span class="grow">退出登录</span>
                                            </a>
                                        </MenuItem>
                                    </div>
                                </div>
                            </MenuItems>
                        </Transition>
                    </Menu>
                </div>
            </div>
        </div>
        <div class="absolute inset-y-0 left-0 flex items-center">
            <div class="hidden md:block">
                <button
                    @click="desktopMenuOpen = !desktopMenuOpen"
                    type="button"
                    class="px-3 py-1 text-gray-700 hover:text-gray-800 focus:text-gray-900"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="block md:hidden">
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    type="button"
                    class="px-3 py-1 text-gray-700 hover:text-gray-800 focus:text-gray-900"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
</template>

<script lang="ts" setup>
    import { computed } from "vue";
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
    import { useAppStore, useUserStore } from "@/store";

    const appStore = useAppStore();
    const userStore = useUserStore();

    defineProps(['title']);

    const desktopMenuOpen = computed({
        get() {
            return appStore.desktopMenuOpen;
        },
        set(n) {
            appStore.toggleMenu(n);
        }
    })

    const mobileMenuOpen = computed({
        get() {
            return appStore.mobileMenuOpen;
        },
        set(n) {
            appStore.toggleMenu(n, 'mobile');
        }
    })

    const userInfo = computed(() => {
        return userStore.userInfo;
    })

    const togglePrompt = (value) => {
        appStore.togglePrompt(value);
    }

</script>
