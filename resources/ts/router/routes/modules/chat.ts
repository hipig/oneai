export const MAIN_LAYOUT = () => import('@/layout/MainLayout.vue');

import { type AppRouteRecordRaw } from '../types';

const CHAT: AppRouteRecordRaw = {
    path: '/chat',
    name: 'chat',
    redirect: '/chat/new',
    component: MAIN_LAYOUT,
    children: [
        {
            path: 'new',
            name: 'chat.new',
            component: () => import('@/views/chat/New.vue'),
            meta: {
                title: '新的聊天',
            },
        },
        {
            path: ':chatId(\\d+)',
            name: 'chat.index',
            component: () => import('@/views/chat/Index.vue'),
        }
    ],
};

export default CHAT;
