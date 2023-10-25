<template>
    <main class="h-full flex flex-col">
        <ChatHeader :title="title" />
        <div class="flex flex-auto flex-col overflow-hidden">
            <simplebar ref="scrollRef" class="h-full">
                <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
                    <div v-if="!messageList" class="animate-pulse w-full flex flex-col-reverse py-2 sm:py-6">
                        <div v-for="i in 8" class="w-full message-item py-3 flex flex-col sm:flex-row items-start sm:space-x-2 space-y-1 sm:space-y-0">
                            <div class="flex md:flex-none">
                                <div class="w-8 h-8 p-px bg-gray-200 border border-gray-200 rounded-full overflow-hidden"></div>
                            </div>
                            <div class="flex-auto py-0.5 space-y-1">
                                <div class="w-64 h-3 bg-gray-200 rounded"></div>
                                <div class="w-full h-3 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="message-list w-full flex flex-col-reverse py-2 sm:py-6">
                        <MessageItem v-for="message in messageList" :type="message.type" :content="message.content" :loading="message?.loading" />
                    </div>
                </div>
            </simplebar>
        </div>
        <footer class="flex flex-none py-6">
            <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
                <ChatInput v-model:loading="loading" />
            </div>
        </footer>
    </main>
</template>

<script lang="ts" setup>
    import {computed, nextTick, onMounted, ref, watch} from 'vue';
    import { useChatStore } from '@/store';
    import ChatHeader from "@/components/chat/Header.vue";
    import ChatInput from '@/components/chat/Input.vue';
    import MessageItem from '@/components/message/Item.vue';

    const chatStore = useChatStore();

    const scrollRef = ref();

    const loading = ref(false);

    const title = computed(() => {
        return chatStore.currentChat?.name;
    })

    const messageList = computed(() => {
        return chatStore.currentMessageList;
    })

    watch(
        messageList,
        async (n) => {
            await nextTick();
            scrollRef.value.scrollElement.scrollTo({
                top: scrollRef.value.scrollElement.scrollHeight,
                behavior: 'smooth'
            })
        },
        {deep: true}
    )
</script>
