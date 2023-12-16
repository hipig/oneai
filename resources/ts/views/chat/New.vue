<template>
    <main class="h-full flex flex-col">
        <ChatHeader title="新的会话" />
        <div class="flex flex-auto flex-col overflow-hidden">
            <simplebar ref="scrollRef" class="h-full">
                <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
                    <div class="message-list flex flex-col-reverse py-2 sm:py-6">
                        <MessageItem type="assistant">
                            <ChatWelcome />
                        </MessageItem>
                    </div>
                </div>
            </simplebar>
        </div>
        <footer class="flex flex-none py-6">
            <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
                <ChatInput />
            </div>
        </footer>
    </main>
</template>

<script lang="ts" setup>
    import {nextTick, onMounted, ref} from "vue";
    import ChatHeader from "@/components/chat/Header.vue";
    import ChatWelcome from "@/components/chat/Welcome.vue";
    import ChatInput from "@/components/chat/input/Index.vue";
    import MessageItem from '@/components/message/Item.vue';

    const scrollRef = ref();

    onMounted(async () => {
        await nextTick();
        scrollRef.value.scrollElement.scrollTo({
            top: scrollRef.value.scrollElement.scrollHeight,
            behavior: 'smooth'
        })
    });
</script>
