import axios from "axios";
import type { AxiosRequestConfig, AxiosResponse } from "axios";
import { toast } from 'vue3-toastify';
import { useUserStore } from "@/store";
import { useRouter } from "vue-router";

export interface HttpResponse<T = unknown> {
    status: number;
    data: T;
}

if (import.meta.env.VITE_API_BASE_URL) {
    axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
}

axios.interceptors.request.use(
    (config: AxiosRequestConfig) => {
        const userStore = useUserStore();
        const token = userStore.token;
        if (token) {
            if (!config.headers) {
                config.headers = {};
            }
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        // do something
        return Promise.reject(error);
    }
);

// add response interceptors
axios.interceptors.response.use(
    (response: AxiosResponse) => {
        return response.data;
    },
    async (error) => {
        const router = useRouter();
        const userStore = useUserStore();
        switch (error.response.status) {
            case 401:
                await userStore.clearToken();
                await router.replace({
                    name: 'chat.new'
                });
                break;
            case 403:
                toast('此操作权限不足 ' + error.response.data?.message);
                break;
            default:
                toast(error.response.data.message || '服务器内部错误');
        }

        return Promise.reject(error);
    }
);
