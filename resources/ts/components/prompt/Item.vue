<template>
    <div class="group relative px-5 py-5 bg-white rounded-2xl shadow-sm hover:shadow cursor-pointer">
        <div class="absolute right-0 top-0 py-4 px-5">
            <button
                class="hidden group-hover:flex w-8 h-8 items-center justify-center bg-gray-100 text-gray-700 hover:bg-gray-200 hover:text-gray-900 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <div class="space-y-1">
                <div class="flex items-center space-x-1">
                    <h3 class="text-lg truncate">{{ name }}</h3>
                </div>
                <div class="h-10 text-gray-500 text-sm line-clamp-2" :title="content">
                    {{ content }}
                </div>
            </div>
            <div class="flex justify-end">
                <button class="px-3 py-1 border border-gray-900 bg-gray-900 text-white rounded-xl" @click="handleUse">
                    使用
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
    import { useChatStore } from '@/store';

    const props =  defineProps(['name', 'content']);
    const emit =  defineEmits(['use']);

    const chatStore = useChatStore();

    const handleUse = () => {
        chatStore.setContent(props.content);
        emit('use');
    }
</script>
