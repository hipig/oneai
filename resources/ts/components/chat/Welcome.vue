<template>
    <div class="rounded-xl bg-white py-2 px-4">
        <div class="py-2 space-y-6">
        <div class="space-y-2">
            <div class="text-2xl font-semibold">你好，我是 ChatGPT</div>
            <p class="text-gray-500">
                作为你的智能伙伴，我既能写文案、想点子，又能陪你聊天、答疑解惑。
            </p>
        </div>
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <div class="text-gray-500">你可以试着问我：</div>
                <div class="flex items-center leading-none divide-x">
                    <a @click="handleRandom" href="javascript:;"
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
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
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
</template>

<script lang="ts" setup>
    import {onMounted, ref} from "vue";
    import { useAppStore } from '@/store';
    import { randomPrompts } from "@/api/prompt";
    import PromptItem from '@/components/prompt/Item.vue';

    const appStore = useAppStore();

    const promptList = ref([]);

    onMounted(async () => {
        await getRandomPromptList();
    });

    const getRandomPromptList = async () => {
        promptList.value = await randomPrompts();
    }

    const handleRandom = async () => {
        await getRandomPromptList();
    }

    const togglePrompt = (value) => {
        appStore.togglePrompt(value);
    }
</script>
