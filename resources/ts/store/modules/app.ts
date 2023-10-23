import { defineStore } from 'pinia';

export interface AppState {
    desktopMenuOpen: boolean;
    mobileMenuOpen: boolean;
    promptOpen: boolean;
}

// @ts-ignore
const useAppStore = defineStore('app', {
    state: (): AppState => ({
        desktopMenuOpen: true,
        mobileMenuOpen: false,
        promptOpen: false
    }),

    getters: {
        appSetting(state: AppState): AppState {
            return { ...state };
        },
    },

    actions: {
        toggleMenu(value: boolean, type: string = 'desktop') {
            if (type === 'desktop') {
                this.desktopMenuOpen = value
            } else {
                this.mobileMenuOpen = value
            }
        },
        togglePrompt(value: boolean) {
            this.promptOpen = value
        }
    },
});

export default useAppStore;
