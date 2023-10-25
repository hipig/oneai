<template>
    <div class="h-screen flex">
        <div class="grow h-full overflow-hidden">
            <div class="h-full relative" :class="{'md:pl-64': desktopMenuOpen}">
                <aside
                    :class="{
                        '-translate-x-full': !mobileMenuOpen,
                        'translate-x-0': mobileMenuOpen,
                        'md:-translate-x-full': !desktopMenuOpen,
                        'md:translate-x-0': desktopMenuOpen,
                    }"
                    class="absolute inset-y-0 left-0 w-full md:w-64 bg-white transition-transform duration-500 ease-out z-10">
                    <div class="h-full flex flex-col w-full border-r border-gray-200 relative">
                        <div class="h-14 shadow-sm flex-none flex items-center justify-between lg:justify-center px-2 w-full dark:bg-gray-600 dark:bg-opacity-25">
                            <div class="flex-auto">
                                <button type="button" class="w-full inline-flex justify-center items-center space-x-2 border font-semibold rounded-xl px-3 py-2 text-sm bg-gray-900 text-white" @click="handleNew">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                    </svg>
                                    <span>新的会话</span>
                                </button>
                            </div>
                            <div class="flex-none">
                                <div class="block md:hidden">
                                    <button
                                        @click="mobileMenuOpen = !mobileMenuOpen"
                                        type="button"
                                        class="px-3 py-1 text-gray-700 hover:text-gray-800 focus:text-gray-900"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-auto flex-col overflow-hidden">
                            <simplebar class="h-full">
                                <div class="px-2 py-4 w-full">
                                    <div v-if="currentView === 'list'">
                                        <ChatList />
                                    </div>
                                    <div v-if="currentView === 'setting'">
                                        <ChatSetting />
                                    </div>
                                </div>
                            </simplebar>
                        </div>
                        <div class="flex flex-none">
                            <div class="w-full flex justify-center py-3 px-2">
                                <div class="w-full flex items-center p-px border border-gray-200 rounded-xl overflow-hidden">
                                    <button
                                        @click="handleToggle('list')"
                                        :class="{'bg-gray-900 hover:bg-gray-800 text-white': currentView === 'list'}"
                                        class="w-1/2 flex items-center justify-center space-x-2 py-1.5 px-3 font-semibold text-sm whitespace-nowrap rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                        <span>历史会话</span>
                                    </button>
                                    <button
                                        @click="handleToggle('setting')"
                                        :class="{'text-gray-400 cursor-not-allowed': !current, 'bg-gray-900 hover:bg-gray-800 text-white': currentView === 'setting'}"
                                        class="w-1/2 flex items-center justify-center space-x-2 py-1.5 px-3 font-semibold text-sm whitespace-nowrap rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                                        </svg>

                                        <span>聊天配置</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
                <RouterView />
            </div>
        </div>
    </div>
    <ChatPrompt />
    <AuthLogin />
</template>

<script lang="ts" setup>
    import {computed, ref} from 'vue';
    import { useRouter } from 'vue-router';
    import { useChatStore, useAppStore } from '@/store';
    import ChatList from '@/components/chat/List.vue';
    import ChatSetting from '@/components/chat/Setting.vue';
    import ChatPrompt from '@/components/chat/Prompt.vue';
    import AuthLogin from '@/components/auth/Login.vue';

    const router = useRouter();

    const chatStore = useChatStore();
    const appStore = useAppStore();

    const currentView = ref('list');

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

    const current = computed(() => {
        return chatStore.current;
    })

    const handleToggle = (view) => {
        if (!current.value && view === 'setting') {
            return false;
        }

        currentView.value = view;
    }

    const handleNew = async () => {
        // const chat = await chatStore.createChat({
        //     name: '新的会话',
        //     model: "gpt-4",
        //     temperature: 0.8,
        //     top_p: 1,
        //     max_tokens: 2000,
        //     presence_penalty: 0,
        //     frequency_penalty: 0,
        // });
        chatStore.setCurrent(undefined);
        await router.push({
            name: 'chat.new'
        });
    }
</script>
