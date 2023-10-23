import { defineStore } from 'pinia';
import { chats, messages, storeChats, updateChats, destroyChats, storeMessages } from '@/api/chat';

export interface ChatState {
    chatList: Array<any>;
    current: number|undefined;
    content: string;
    messageList: Array<any>;
}

// @ts-ignore
const useChatStore = defineStore('chat', {
    state: (): ChatState => ({
        chatList: [],
        current: undefined,
        content: '',
        messageList: []
    }),
    getters: {
        currentChat(state: ChatState) {
            const index = state.chatList.findIndex(item => item.id === state.current)
            if (index > -1) {
                return state.chatList[index]
            }

            return null
        },
        currentMessageList(state: ChatState) {
            const index = state.messageList.findIndex(item => item.chat_id === state.current)
            if (index > -1) {
                return state.messageList[index].list
            }

            return null
        }
    },

    actions: {
        setCurrent(current) {
            this.current = current;
            this.getMessageList();
        },
        setContent(content) {
            this.content = content;
        },
        async getChatList() {
            this.chatList = await chats();
        },
        async createChat(chat: any) {
            this.chatList.unshift(chat);
            const res = await storeChats(chat);
            this.chatList[0] = res;
            return res;
        },
        async updateChatConfig(config: any) {
            const index = this.chatList.findIndex(item => item.id === this.current)
            if (index > -1) {
                this.chatList[index].config = config;
                await updateChats(this.current, {config});
            }
        },
        async deleteChat(chat: any) {
            const index = this.chatList.findIndex(item => item.id === chat.id)
            if (index > -1) {
                this.chatList.splice(index, 1);
                await destroyChats(chat.id);
            }
        },
        async getMessageList() {
            const index = this.messageList.findIndex(item => item.chat_id === this.current);

            if (index === -1) {
                const messageList = await messages({
                    chat_id: this.current
                });

                this.messageList.push({
                    chat_id: this.current,
                    list: messageList
                });
            }
        },
        async createMessage(message: any, chatId: number|null = null) {
            this.updateOrCreate(chatId, message);
            const res = await storeMessages({
                ...message,
                chat_id: chatId
            })
            const index = this.messageList.findIndex(item => item.chat_id === chatId);
            this.messageList[index].list[0] = res;

            return res;
        },
        updateOrCreate(chatId, message) {
            const index = this.messageList.findIndex(item => item.chat_id === chatId);
            if (index > -1) {
                this.messageList[index].list.unshift(message);
            } else {
                this.messageList.push({
                    chat_id: chatId,
                    list: [message]
                })
            }
        }
    },
});

export default useChatStore;
