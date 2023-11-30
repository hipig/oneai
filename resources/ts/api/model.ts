import axios from 'axios';

export interface ModelRecord {
    name: string;
    group: string;
    rank: number;
    status: number;
}

export function models() {
    return axios.get<ModelRecord[]>('models');
}
