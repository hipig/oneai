<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="togglePrompt(false)">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0" @afterEnter="getCategoryList">
                <div class="fixed inset-0 bg-gray-400 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <DialogPanel class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-screen-xl">
                        <div class=" absolute top-0 right-0 p-4">
                            <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100" @click="togglePrompt(false)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="bg-white px-6 pt-2">
                            <div class="flex items-end px-4 py-2">
                                <div class="flex-auto space-y-6">
                                    <div class="text-3xl">指令大全</div>
                                    <div class="flex items-center space-x-6">
                                        <button class="text-lg font-semibold py-1 px-2 border-b-2 border-gray-900">场景</button>
                                        <button class="text-lg py-1 px-2 border-b-2 border-transparent">我的收藏</button>
                                    </div>
                                </div>
                                <div class="flex-none py-1">
                                    <div class="relative">
                                        <input type="text" class="w-96 py-2.5 px-4 text-lg bg-gray-100 border-gray-100 focus:bg-white focus:border-gray-900 focus:ring-gray-900 rounded-2xl" placeholder="输入指令关键词">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-6 py-6 space-y-6">
                            <div class="flex items-center space-x-4">
                                <template v-if="groupList.length === 0">
                                    <div v-for="i in 4" class="h-4 w-20 bg-gray-200 rounded"></div>
                                </template>
                                <button v-for="group in groupList" type="button" class=" leading-snug px-4 py-2 rounded-2xl" :class="[currentGroupId == group.id ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 hover:text-gray-800']" @click="handleChange(group)">{{  group.name }}</button>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <template v-if="promptList.length === 0">
                                    <div v-for="i in 6" class="animate-pulse relative px-5 py-5 bg-white rounded-2xl shadow-sm hover:shadow cursor-pointer">
                                        <div class="space-y-4">
                                            <div class="space-y-2">
                                                <div class="flex items-center space-x-1">
                                                    <div class="h-4 w-24 bg-gray-200 rounded"></div>
                                                </div>
                                                <div class="space-y-2">
                                                    <div class="h-3 bg-gray-200 rounded"></div>
                                                    <div class="h-3 bg-gray-200 rounded"></div>
                                                </div>
                                            </div>
                                            <div class="flex justify-end">
                                                <div class="h-4 w-16 bg-gray-200 rounded"></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <PromptItem v-for="prompt in promptList" :name="prompt.name" :content="prompt.content" @use="handleUse"></PromptItem>
                            </div>
                        </div>
                    </DialogPanel>
                </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script lang="ts" setup>
    import { ref, computed, onMounted } from 'vue';
    import { useAppStore } from '@/store';
    import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
    import PromptItem from '../prompt/Item.vue';
    import { promptGroups } from '@/api/prompt';

    const appStore = useAppStore();

    const open = computed(() => {
        return !!appStore.promptOpen;
    });

    const groupList = ref([]);

    const currentGroupId = ref(0);

    const promptList = ref([]);

    const getCategoryList = async () => {
        groupList.value = await promptGroups();

        if (groupList.value) {
            const firstGroup = groupList.value[0];
            currentGroupId.value = firstGroup?.id;
            promptList.value = firstGroup?.prompts;
        }
    }

    const handleChange = (group) => {
        currentGroupId.value = group?.id;
        promptList.value = group?.prompts;
    }

    const togglePrompt = (value) => {
        appStore.togglePrompt(value);
    }

    const handleUse = () => {
        appStore.togglePrompt(false);
    }
</script>
