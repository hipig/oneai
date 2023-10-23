<template>
    <main class="h-full flex flex-col">
        <ChatHeader />
        <div class="flex flex-auto">
            <div class="w-full max-w-screen-xl mx-auto px-4 lg:px-6">
                <div class="w-full py-8">
                    <div class="flex items-start space-x-2">
                        <div class="flex flex-none text-gray-700 py-1">
                            <div class="w-8 h-8 bg-white p-px border border-gray-200 rounded-full overflow-hidden">
                                <svg viewBox="140 140 520 520" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                    <path
                                        d="m617.24 354a126.36 126.36 0 0 0 -10.86-103.79 127.8 127.8 0 0 0 -137.65-61.32 126.36 126.36 0 0 0 -95.31-42.49 127.81 127.81 0 0 0 -121.92 88.49 126.4 126.4 0 0 0 -84.5 61.3 127.82 127.82 0 0 0 15.72 149.86 126.36 126.36 0 0 0 10.86 103.79 127.81 127.81 0 0 0 137.65 61.32 126.36 126.36 0 0 0 95.31 42.49 127.81 127.81 0 0 0 121.96-88.54 126.4 126.4 0 0 0 84.5-61.3 127.82 127.82 0 0 0 -15.76-149.81zm-190.66 266.49a94.79 94.79 0 0 1 -60.85-22c.77-.42 2.12-1.16 3-1.7l101-58.34a16.42 16.42 0 0 0 8.3-14.37v-142.39l42.69 24.65a1.52 1.52 0 0 1 .83 1.17v117.92a95.18 95.18 0 0 1 -94.97 95.06zm-204.24-87.23a94.74 94.74 0 0 1 -11.34-63.7c.75.45 2.06 1.25 3 1.79l101 58.34a16.44 16.44 0 0 0 16.59 0l123.31-71.2v49.3a1.53 1.53 0 0 1 -.61 1.31l-102.1 58.95a95.16 95.16 0 0 1 -129.85-34.79zm-26.57-220.49a94.71 94.71 0 0 1 49.48-41.68c0 .87-.05 2.41-.05 3.48v116.68a16.41 16.41 0 0 0 8.29 14.36l123.31 71.19-42.69 24.65a1.53 1.53 0 0 1 -1.44.13l-102.11-59a95.16 95.16 0 0 1 -34.79-129.81zm350.74 81.62-123.31-71.2 42.69-24.64a1.53 1.53 0 0 1 1.44-.13l102.11 58.95a95.08 95.08 0 0 1 -14.69 171.55c0-.88 0-2.42 0-3.49v-116.68a16.4 16.4 0 0 0 -8.24-14.36zm42.49-63.95c-.75-.46-2.06-1.25-3-1.79l-101-58.34a16.46 16.46 0 0 0 -16.59 0l-123.31 71.2v-49.3a1.53 1.53 0 0 1 .61-1.31l102.1-58.9a95.07 95.07 0 0 1 141.19 98.44zm-267.11 87.87-42.7-24.65a1.52 1.52 0 0 1 -.83-1.17v-117.92a95.07 95.07 0 0 1 155.9-73c-.77.42-2.11 1.16-3 1.7l-101 58.34a16.41 16.41 0 0 0 -8.3 14.36zm23.19-50 54.92-31.72 54.92 31.7v63.42l-54.92 31.7-54.92-31.7z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-auto">
                            <div class="w-full py-6 px-4 relative bg-white rounded-2xl">
                                <div class="space-y-8">
                                    <div class="space-y-2">
                                        <div class="text-3xl font-semibold">你好，我是 ChatGPT</div>
                                        <p class="text-gray-500">
                                            作为你的智能伙伴，我既能写文案、想点子，又能陪你聊天、答疑解惑。
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <div class="text-gray-500">你可以试着问我：</div>
                                            <div class="flex items-center leading-none divide-x">
                                                <a href="javascript:;"
                                                    class="px-3 flex items-center text-gray-800 hover:text-gray-900 space-x-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                                    </svg>
                                                    <span>换一换</span>
                                                </a>
                                                <a @click="togglePrompt(true)" href="javascript:;"
                                                    class="px-3 flex items-center text-gray-800 hover:text-gray-900">
                                                    <span>查看更多</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 p-6 rounded-xl">
                                            <div class="grid grid-cols-3 gap-6">
                                                <template v-if="promptList.length === 0">
                                                    <div v-for="i in 6" class="animate-pulse relative px-5 py-5 bg-white rounded-2xl shadow-sm hover:shadow cursor-pointer">
                                                        <div class="space-y-4">
                                                            <div class="space-y-2">
                                                                <div class="flex items-center space-x-1">
                                                                    <div class="h-4 w-24 bg-gray-200 rounded"></div>
                                                                </div>
                                                                <div class="space-y-2">
                                                                    <div class="h-3 bg-gray-200 rounded"></div>
                                                                    <div class="h-3 bg-gray-200 rounded"></div>
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <div class="h-4 w-16 bg-gray-200 rounded"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                <PromptItem v-for="prompt in promptList" :name="prompt.name"  :content="prompt.content" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="flex flex-none py-6">
            <div class="w-full max-w-screen-xl mx-auto px-4 lg:px-6">
                <ChatInput />
            </div>
        </footer>
    </main>
</template>

<script lang="ts" setup>
    import { onMounted, ref } from "vue";
    import { useAppStore } from "@/store";
    import { randomPrompts } from "@/api/prompt";
    import ChatHeader from "@/components/chat/Header.vue";
    import ChatInput from "@/components/chat/Input.vue";
    import PromptItem from "@/components/prompt/Item.vue";

    const appStore = useAppStore();

    const promptList = ref([]);

    onMounted(() => {
        getRandomPromptList();
    });

    const getRandomPromptList = async () => {
        promptList.value = await randomPrompts();
    }

    const togglePrompt = (value) => {
        appStore.togglePrompt(value);
    }
</script>
