import axios from 'axios';

export interface PromptGroupRecord {
    id: number;
    name: string;
    prompts: Array<PromptRecord>
}

export interface PromptRecord {
    name: string;
    content: string;
}

export function promptGroups() {
    return axios.get<PromptGroupRecord[]>('prompt-groups');
}

export function randomPrompts(size = 6) {
    return axios.get<PromptRecord[]>('prompts/random', {params: { size }});
}
