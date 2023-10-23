import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import useAppStore from './modules/app';
import useUserStore from './modules/user';
import useChatStore from './modules/chat';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

export { useAppStore, useUserStore, useChatStore };
export default pinia;

