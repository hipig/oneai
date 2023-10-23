<template>
    <div class="flex items-center space-x-2">
        <div class="flex-none w-6">
            <span>{{ _value }}</span>
        </div>
        <div class="flex-auto">
            <input type="range" v-model="_value" v-bind="$attrs" class="w-full h-2.5 bg-white border [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:bg-gray-900 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 shadow-sm">
        </div>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';

    const props = defineProps({
        modelValue: Number
    });
    const emit = defineEmits(['update:modelValue']);

    const _value = computed({
        get() {
            return props.modelValue;
        },
        set(n) {
            emit('update:modelValue', n);
        }
    })
</script>
