<template>
    <div class=" md:pb-8 relative">
        <div class="relative rounded-xl leading-none">
            <textarea ref="textInput" placeholder="你可以问我任何问题" v-model="content" @keyup.ctrl.enter="handleSubmit" rows="1" class="w-full py-2.5 px-4 pr-14 border-gray-200 bg-white focus:border-gray-900 focus:ring-gray-900 rounded-xl shadow-sm"></textarea>
            <div class="absolute bottom-0 right-0 flex items-center px-2 py-1.5">
                <button title="发送" type="button" @click="handleSubmit" class="p-1.5 flex items-center justify-center leading-none hover:bg-gray-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </button>
            </div>
            <div v-if="loading" class="absolute inset-0 bg-gray-50 border border-gray-200 rounded-xl flex items-end">
                <div class="h-full flex flex-auto items-center space-x-4 px-4 cursor-not-allowed">
                    <svg class="animate-spin h-6 w-6 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-gray-500">正在响应您的问题...</span>
                </div>
                <div class="flex flex-none px-2 py-1.5">
                    <button title="停止响应" type="button" @click="handleCancel" class="p-1.5 flex items-center justify-center leading-none text-gray-800 hover:text-gray-900 hover:bg-gray-100 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm6-2.438c0-.724.588-1.312 1.313-1.312h4.874c.725 0 1.313.588 1.313 1.313v4.874c0 .725-.588 1.313-1.313 1.313H9.564a1.312 1.312 0 01-1.313-1.313V9.564z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="absolute right-0 h-8 items-center px-px hidden md:flex">
            <span class="text-sm text-gray-500">{{ loading ? '点击取消': 'Ctrl + Enter 或点击发送' }}</span>
        </div>
    </div>

</template>

<script lang="ts" setup>
import {computed, nextTick, onMounted, ref, watch} from "vue";
import {useRouter} from "vue-router";
import {useChatStore, useUserStore} from "@/store";
import {storeMessages} from "@/api/chat";
import autosize from "autosize";
import {SSE} from "sse.js";

const router = useRouter();

    const chatStore = useChatStore();
    const userStore = useUserStore();

    const content = computed({
        get() {
            return chatStore.content;
        },
        set(n) {
            chatStore.setContent(n);
        }
    });

    const loading = ref(false);

    const eventSource = ref();

    watch(
        content,
        (n) => {
            nextTick(() => {
                autosize.update(textInput.value);
                if (!loading.value) {
                    textInput.value.focus();
                }
            })
        }
    )

    onMounted(() => {
        window.addEventListener('keydown', async (e) => {
            switch (e.key) {
                case 'Escape':
                    if (loading.value) {
                        await handleCancel();
                    }
                    break;
            }
        })
    })

    const handleSubmit = async () => {
        if (!content.value) {
            return false;
        }
        textInput.value.blur();
        loading.value = true;

        let chatId = chatStore.current;
        if (!chatId) {
            const chat = await chatStore.createChat({
                name: content.value
            });
            chatId = chat.id;
            chatStore.setCurrent(chatId);
            await router.push({name: 'chat.index', params: { chatId }});
        }

        await chatStore.createMessage({
            type: "user",
            content: content.value,
        }, chatId);

        content.value = '';

        const index = chatStore.messageList.findIndex(item => item.chat_id === chatId);
        chatStore.messageList[index].list.unshift({
            type: 'assistant',
            content: '',
            loading: true
        });

        const headers = {};
        const token = userStore.token;
        if (token) {
            headers.Authorization = `Bearer ${token}`;
        }

        eventSource.value = new SSE(`/api/chats/${chatId}/stream`, {
            headers,
            method: 'POST'
        });

        eventSource.value.onmessage = async function (e) {
            let data = JSON.parse(e.data);
            if (data.finishReason === 'stop') {
                await stopResponse();
            } else {
                let assistantContent = chatStore.messageList[index].list[0].content || '';
                assistantContent += data.delta?.content || '';
                chatStore.messageList[index].list[0].content = assistantContent;
            }
        };
        eventSource.value.onerror = function (e) {
            console.log(e);
            eventSource.value.close();
            loading.value = false;
            chatStore.messageList[index].list[0].loading = false;
        };


    }

    const stopResponse = async () => {
        eventSource.value.close();
        loading.value = false;
        const chatId = chatStore.current;
        const index = chatStore.messageList.findIndex(item => item.chat_id === chatId);
        chatStore.messageList[index].list[0] = await storeMessages({
            type: 'assistant',
            content: chatStore.messageList[index].list[0].content,
            chat_id: chatId
        });
    }

    const handleCancel = async () => {
        await stopResponse();
    }

    const textInput = ref();
    onMounted(() => {
        autosize(textInput.value);
    })
</script>
