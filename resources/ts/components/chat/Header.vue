<template>
    <header class="h-14 flex-none flex items-center bg-white shadow-sm relative">
        <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
            <div class="flex items-center">
                <div class="flex-auto">
                    <h3 class="text-lg pl-10 md:pl-0">{{ title }}</h3>
                </div>
                <div class="flex-none space-x-4">
                    <button
                        class="px-4 py-1.5 flex items-center space-x-1 text-gray-800 rounded-xl hover:text-gray-900 hover:bg-gray-100"
                        @click="togglePrompt(true)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                        </svg>

                        <span>指令大全</span>
                    </button>
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
    import { useAppStore, useChatStore } from "@/store";

    const appStore = useAppStore();

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

    const togglePrompt = (value) => {
        appStore.togglePrompt(value);
    }

</script>
