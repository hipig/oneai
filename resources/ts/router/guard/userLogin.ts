import type { Router } from 'vue-router';
import { useUserStore } from '@/store';

export default function setupUserLoginGuard(router: Router) {
    router.beforeEach(async (to, from, next) => {
        const userStore = useUserStore();
        if (userStore.token) {
            if (!userStore.userInfo.id) {
                await userStore.getUserInfo();
            }
        };

        next();
    });
    router.afterEach(() => {
        //
    })
}
