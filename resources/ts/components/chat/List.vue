<template>
    <div class="space-y-1">
        <template v-if="!loaded">
            <div v-for="i in 4" class="animate-pulse px-3 py-2 flex items-center">
                <div class="flex-auto flex items-center space-x-2">
                    <div class="flex-none">
                        <div class="rounded-full bg-gray-200 h-6 w-6"></div>
                    </div>
                    <div class="flex-auto">
                        <div class="h-3 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>
        </template>
        <div v-if="loaded && chatList.length === 0" class="flex justify-center py-8">
            <div class="flex flex-col items-center space-y-1 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>
                <div>会话列表为空</div>
            </div>
        </div>
        <div v-if="loaded" v-for="chat in chatList" class="px-3 py-2.5 flex items-center rounded-xl cursor-pointer" :class="[currentChatId === chat.id ? 'bg-gray-100 text-gray-900' : 'hover:bg-gray-100 hover:text-gray-900']" @click="selectChat(chat.id)">
            <div class="flex flex-auto items-center space-x-2">
                <div class="flex-none text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
                <div class="flex-auto truncate">
                    {{ chat.name }}
                </div>
            </div>
            <div class="flex-none flex items-center space-x-1" v-if="currentChatId === chat.id" @click="handleDelete(chat)">
                <button type="button" class="text-gray-500 hover:text-gray-900 focus:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
    import { ref, computed, onMounted } from 'vue';
    import {useRoute, useRouter} from 'vue-router';
    import { useChatStore } from '@/store';
    import { detoryChats } from '@/api/chat';

    const route = useRoute();
    const router = useRouter();

    const chatStore = useChatStore();

    const currentChatId = computed(() => {
        return chatStore.current;
    });

    const chatList = computed(() => {
        return chatStore.chatList;
    });

    const loaded = ref(false);

    onMounted(async () => {
        await getChatList();
    })

    const getChatList = async () => {
        await chatStore.getChatList();
        loaded.value = true;

        selectChat(parseInt(route.params.chatId));
    }

    const selectChat = async (chatId) => {
        if (!chatId) {
            return false;
        }

        if (chatId !== currentChatId.value) {
            chatStore.setCurrent(chatId);
            await router.push({name: 'chat.index', params: {chatId}});
        }
    }

    const handleDelete = async (chat) => {
        await chatStore.deleteChat(chat);
        if (chatStore.chatList[0]?.id) {
            selectChat(chatStore.chatList[0]?.id);
        } else {
            await router.push({name: 'chat.new'})
        }
    }
</script>
