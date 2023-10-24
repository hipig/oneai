<template>
    <div class="message-item py-3 flex items-start space-x-2" v-if="$slots.default || content">
        <div class="flex flex-none text-gray-700 py-1">
            <div class="w-8 h-8 bg-white p-px border border-gray-200 rounded-full overflow-hidden">
                <img v-if="type === 'user'" class="w-full h-full rounded-full" :src="userInfo.avatar" :alt="userInfo.name">
                <svg v-if="type === 'assistant'" viewBox="140 140 520 520" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                    <path d="m617.24 354a126.36 126.36 0 0 0 -10.86-103.79 127.8 127.8 0 0 0 -137.65-61.32 126.36 126.36 0 0 0 -95.31-42.49 127.81 127.81 0 0 0 -121.92 88.49 126.4 126.4 0 0 0 -84.5 61.3 127.82 127.82 0 0 0 15.72 149.86 126.36 126.36 0 0 0 10.86 103.79 127.81 127.81 0 0 0 137.65 61.32 126.36 126.36 0 0 0 95.31 42.49 127.81 127.81 0 0 0 121.96-88.54 126.4 126.4 0 0 0 84.5-61.3 127.82 127.82 0 0 0 -15.76-149.81zm-190.66 266.49a94.79 94.79 0 0 1 -60.85-22c.77-.42 2.12-1.16 3-1.7l101-58.34a16.42 16.42 0 0 0 8.3-14.37v-142.39l42.69 24.65a1.52 1.52 0 0 1 .83 1.17v117.92a95.18 95.18 0 0 1 -94.97 95.06zm-204.24-87.23a94.74 94.74 0 0 1 -11.34-63.7c.75.45 2.06 1.25 3 1.79l101 58.34a16.44 16.44 0 0 0 16.59 0l123.31-71.2v49.3a1.53 1.53 0 0 1 -.61 1.31l-102.1 58.95a95.16 95.16 0 0 1 -129.85-34.79zm-26.57-220.49a94.71 94.71 0 0 1 49.48-41.68c0 .87-.05 2.41-.05 3.48v116.68a16.41 16.41 0 0 0 8.29 14.36l123.31 71.19-42.69 24.65a1.53 1.53 0 0 1 -1.44.13l-102.11-59a95.16 95.16 0 0 1 -34.79-129.81zm350.74 81.62-123.31-71.2 42.69-24.64a1.53 1.53 0 0 1 1.44-.13l102.11 58.95a95.08 95.08 0 0 1 -14.69 171.55c0-.88 0-2.42 0-3.49v-116.68a16.4 16.4 0 0 0 -8.24-14.36zm42.49-63.95c-.75-.46-2.06-1.25-3-1.79l-101-58.34a16.46 16.46 0 0 0 -16.59 0l-123.31 71.2v-49.3a1.53 1.53 0 0 1 .61-1.31l102.1-58.9a95.07 95.07 0 0 1 141.19 98.44zm-267.11 87.87-42.7-24.65a1.52 1.52 0 0 1 -.83-1.17v-117.92a95.07 95.07 0 0 1 155.9-73c-.77.42-2.11 1.16-3 1.7l-101 58.34a16.41 16.41 0 0 0 -8.3 14.36zm23.19-50 54.92-31.72 54.92 31.7v63.42l-54.92 31.7-54.92-31.7z"></path>
                </svg>
            </div>
        </div>
        <div class="min-w-[20rem] py-2 px-4 rounded-xl" :class="[type === 'assistant' ? 'bg-white' : 'bg-gray-100']">
            <slot>
                <div class="prose max-w-none" :class="{'content-loading':  type === 'assistant' && loading, 'whitespace-pre-wrap': type === 'user'}" v-html="content"></div>
            </slot>
        </div>
    </div>
</template>

<script lang="ts" setup>
    import { computed, onMounted, onUnmounted, onUpdated, ref } from 'vue';
    import { useUserStore } from '@/store';
    import MarkdownIt from 'markdown-it';
    import mdKatex from '@traptitech/markdown-it-katex';
    import mila from 'markdown-it-link-attributes';
    import hljs from 'highlight.js/lib/common';

    const props = defineProps(['type', 'content', 'loading']);

    const userStore = useUserStore();

    const userInfo = computed(() => {
        return userStore.userInfo;
    })

    const textRef = ref<HTMLElement>()

    const mdi = new MarkdownIt({
        html: false,
        linkify: true,
        highlight(code, language) {
            const validLang = !!(language && hljs.getLanguage(language))
            if (validLang) {
            const lang = language ?? ''
            return highlightBlock(hljs.highlight(code, { language: lang }).value, lang)
            }
            return highlightBlock(hljs.highlightAuto(code).value, '')
        },
    });
    mdi.use(mila, { attrs: { target: '_blank', rel: 'noopener' } });
    mdi.use(mdKatex, { blockClass: 'katexmath-block rounded-md p-[10px]', errorColor: ' #cc0000' });

    const content = computed(() => {
        const value = props.content ?? ''
        if (value && props.type === 'assistant')
            return mdi.render(value);
        return value;
    })

    const highlightBlock = (str: string, lang?: string) => {
        return `<pre class="relative overflow-auto whitespace-normal break-all group">
                    <div class="absolute top-0 right-0 px-1 h-6 items-center hidden group-hover:flex">
                        <div class="flex items-center cursor-pointer text-gray-400 hover:text-gray-200 code-block-header__copy">
                            <span class="text-xs">复制代码</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                            </svg>
                        </div>
                    </div>
                    <code class="hljs code-block-body ${lang}">${str}</code>
                </pre>`;
    }


    function addCopyEvents() {
        if (textRef.value) {
            const copyBtn = textRef.value.querySelectorAll('.code-block-header__copy')
            copyBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                const code = btn.parentElement?.nextElementSibling?.textContent
                if (code) {
                copyToClip(code).then(() => {
                    btn.textContent = '复制成功'
                    setTimeout(() => {
                    btn.textContent = '复制代码'
                    }, 1000)
                })
                }
            })
            })
        }
    }

    function removeCopyEvents() {
        if (textRef.value) {
            const copyBtn = textRef.value.querySelectorAll('.code-block-header__copy')
            copyBtn.forEach((btn) => {
            btn.removeEventListener('click', () => {})
            })
        }
    }

    onMounted(() => {
        addCopyEvents()
    })

    onUpdated(() => {
        addCopyEvents()
    })

    onUnmounted(() => {
        removeCopyEvents()
    })
</script>

<style lang="css">
    pre code.hljs {
        border-radius: 6px;
        white-space:pre-wrap;
        word-wrap:break-word;
    }

    .content-loading>dd:last-child:after,
    .content-loading>dl:last-child:after,
    .content-loading>dt:last-child:after,
    .content-loading>h1:last-child:after,
    .content-loading>h2:last-child:after,
    .content-loading>h3:last-child:after,
    .content-loading>h4:last-child:after,
    .content-loading>h5:last-child:after,
    .content-loading>h6:last-child:after,
    .content-loading>li:last-child:after,
    .content-loading>ol:last-child li:last-child:after,
    .content-loading>p:last-child:after,
    .content-loading>pre:last-child code:after,
    .content-loading>td:last-child:after,
    .content-loading>ul:last-child li:last-child:after {
        animation: blink 1s steps(5, start) infinite;
        color: #000;
        content: '_';
        font-weight: 700;
        margin-left: 3px;
        vertical-align: baseline;
    }

    @keyframes blink {
        to {
            visibility: hidden;
        }
    }
</style>
