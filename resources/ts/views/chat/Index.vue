<template>
    <main class="h-full flex flex-col">
        <ChatHeader :title="title" />
        <div class="flex flex-auto flex-col overflow-hidden">
            <simplebar ref="scrollRef" class="h-full">
                <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
                    <div class="message-list w-full flex flex-col-reverse py-2 sm:py-6">
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
