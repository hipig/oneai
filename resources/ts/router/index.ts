import { createRouter, createWebHistory } from 'vue-router'

import appRoutes from './routes';
import createRouteGuard from './guard';

export const MAIN_LAYOUT = () => import('@/layout/MainLayout.vue');

const router = createRouter({
    history: createWebHistory('/'),
    routes: [
        {
            path: '/',
            redirect: '/chat',
            component: MAIN_LAYOUT
        },
        ...appRoutes,
    ],
})

createRouteGuard(router);

export default router
