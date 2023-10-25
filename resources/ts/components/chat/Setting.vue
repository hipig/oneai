<template>
    <div class="px-2 space-y-6">
        <div class="space-y-2">
            <div>
                <label class="block font-medium">模型</label>
                <p class="text-sm text-gray-500">模型不同，消耗额度不同</p>
            </div>
            <select v-model="config.model" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-gray-900 focus:ring-gray-900">
                <option value="gpt-3.5-turbo">GPT3.5-Turbo</option>
                <option value="gpt-4">GPT4</option>
            </select>
        </div>
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
</template>

<script lang="ts" setup>
import { computed, ref, watch } from 'vue';
import { useChatStore } from '@/store';
import RangeInput from '@/components/form/range/Index.vue';

    const chatStore = useChatStore();

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
</script>
