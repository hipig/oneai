import { createRouter, createWebHistory } from 'vue-router'

import appRoutes from './routes';
import createRouteGuard from './guard';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            redirect: 'chat/new',
        },
        ...appRoutes,
    ],
})

createRouteGuard(router);

export default router
