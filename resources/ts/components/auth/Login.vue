<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-400 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <DialogPanel class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                        <div class="bg-gray-50 text-xl px-6 py-3 text-center">用户登录</div>
                        <div class="px-8 py-6">
                            <form action="#" class="space-y-6">
                                <div class="space-y-1">
                                    <label class="" for="">用户名</label>
                                    <div>
                                        <input type="text" v-model="loginForm.username" class="w-full px-4 py-3 bg-gray-100 border-gray-100 focus:border-gray-900 focus:ring-gray-900 rounded-xl"  placeholder="请输入用户名">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="" for="">密码</label>
                                    <div>
                                        <input type="password" v-model="loginForm.password" class="w-full px-4 py-3 bg-gray-100 border-gray-100 focus:border-gray-900 focus:ring-gray-900 rounded-xl"  placeholder="请输入密码">
                                    </div>
                                </div>
                                <button type="button" class="w-full px-4 py-3 bg-gray-900 text-white rounded-xl" @click="handleSubmit">立即登录</button>
                            </form>
                        </div>
                    </DialogPanel>
                </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script lang="ts" setup>
    import { ref, computed } from 'vue';
    import { useRouter } from "vue-router";
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import { useUserStore } from '@/store';
    import { toast } from 'vue3-toastify';

    const router = useRouter();

    const userStore = useUserStore();

    const loginForm = ref({
        username: '',
        password: ''
    })

    const open = computed(() => {
        return !!!userStore.token;
    })

    const handleSubmit = async () => {
        try {
            await userStore.login(loginForm.value);
            router.go(0);
        } catch (e) {
            const response = e.response;
            if (response?.status === 401) {
                toast(response.data.message);
            }
        }
    }
</script>
