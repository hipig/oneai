<template>
    <main class="h-full flex flex-col">
        <ChatHeader title="新的会话" />
        <div class="flex flex-auto">
            <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
                <div class="message-list w-full flex flex-col-reverse py-6">
                    <MessageItem type="assistant">
                        <ChatWelcome />
                    </MessageItem>
                </div>
            </div>
        </div>
        <footer class="flex flex-none py-6">
            <div class="w-full max-w-screen-lg mx-auto px-4 lg:px-6">
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
    import ChatWelcome from "@/components/chat/Welcome.vue";
    import ChatInput from "@/components/chat/Input.vue";
    import MessageItem from '@/components/message/Item.vue';

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
