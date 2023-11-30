import axios from 'axios';

export interface ChatRecord {
    id: number;
    name: string;
    config: object;
}

export interface MessageRecord {
    id: number;
    type: string;
    content: string;
    start: boolean;
}

export function chats() {
    return axios.get<ChatRecord[]>('chats');
}

export function storeChats(data: any) {
    return axios.post<ChatRecord>('chats', data);
}

export function updateChats(id: number, data: any) {
    return axios.put<ChatRecord>('chats/' + id, data);
}

export function destroyChats(id: number) {
    return axios.delete('chats/' + id);
}

export function messages(params: any) {
    return axios.get<MessageRecord[]>('messages', {params});
}

export function storeMessages(data: any) {
    return axios.post<ChatRecord>('messages', data);
}

export function destroyMessages(id: number) {
    return axios.delete<ChatRecord>('messages/' + id);
}
