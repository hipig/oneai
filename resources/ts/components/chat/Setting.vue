<template>
    <div class="px-2 space-y-6">
        <div class="space-y-2">
            <div>
                <label class="block font-medium">模型</label>
                <p class="text-sm text-gray-500">模型不同，消耗额度不同</p>
            </div>
            <select v-model="config.model" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-gray-900 focus:ring-gray-900">
                <option v-for="model in modelList" :value="model.name">{{ model.name }}</option>
            </select>
        </div>
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
                <div class="flex-auto h-px rounded bg-gray-200"></div>
                <button class="flex items-center space-x-1" @click="moreVisible = !moreVisible">
                    <span class="font-medium">{{ moreVisible ? '收起设置' : '更多设置' }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 duration-200 ease-in-out" :class="[moreVisible ? 'rotate-180' : '']">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="flex-auto h-px rounded bg-gray-200"></div>
            </div>
            <div class="space-y-6" v-if="moreVisible">
                <div class="space-y-2">
                    <div>
                        <label class="block font-medium">随机性</label>
                        <p class="text-sm text-gray-500">值越大，回复越随机</p>
                    </div>
                    <RangeInput v-model="config.temperature" :min="0" :max="2" :step="0.1" />
                </div>
                <div class="space-y-2">
                    <div>
                        <label class="block font-medium">核采样</label>
                        <p class="text-sm text-gray-500">与随机性类似，不要和随机性同时更改</p>
                    </div>
                    <RangeInput v-model="config.top_p" :min="0.1" :max="1" :step="0.1" />
                </div>
                <div class="space-y-2">
                    <div>
                        <label class="block font-medium">单次回复限制</label>
                        <p class="text-sm text-gray-500">单次交互所用的最大 Token 数</p>
                    </div>
                    <input type="number" v-model="config.max_tokens" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-gray-900 focus:ring-gray-900">
                </div>
                <div class="space-y-2">
                    <div>
                        <label class="block font-medium">话题新鲜度</label>
                        <p class="text-sm text-gray-500">值越大，越有可能扩展到新话题</p>
                    </div>
                    <RangeInput v-model="config.presence_penalty" :min="-2" :max="2" :step="0.1" />
                </div>
                <div class="space-y-2">
                    <div>
                        <label class="block font-medium">频率惩罚度</label>
                        <p class="text-sm text-gray-500">值越大，越有可能降低重复字词</p>
                    </div>
                    <RangeInput v-model="config.frequency_penalty" :min="-2" :max="2" :step="0.1" />
                </div>
            </div>
        </div>
        <button type="button" class="w-full inline-flex justify-center items-center space-x-2 border border-red-700 font-semibold rounded-xl px-3 py-2 text-sm bg-red-50 text-red-700" @click="handleNew">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
            <span>清空聊天</span>
        </button>
    </div>
</template>

<script lang="ts" setup>
import {computed, onMounted, ref, watch} from 'vue';
    import { useChatStore } from '@/store';
    import RangeInput from '@/components/form/range/Index.vue';
    import { models } from '@/api/model';

    const chatStore = useChatStore();

    const modelList = ref([]);

    const moreVisible = ref(false);

    const config = ref(Object.assign({
                model: "gpt-4",
                temperature: 0.8,
                top_p: 1,
                max_tokens: 2000,
                presence_penalty: 0,
                frequency_penalty: 0,
            }, chatStore.currentChat?.config));

    watch(
        config,
        (n) => {
            chatStore.updateChatConfig(n);
        },
        {deep: true}
    )

    onMounted(async () => {
        await getModelList();
    });

    const getModelList = async () => {
        modelList.value = await models();
    }
</script>
