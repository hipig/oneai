import axios from 'axios';

export interface LoginResRecord {
    access_token: string;
    token_type: string;
    expires_in: string;
}

export interface UserRecord {
    username: string;
    name: string;
    avatar: string;
    email: string;
}
  
  
export function authorizations(data) {
    return axios.post<LoginResRecord>('authorizations', data);
}

export function me() {
    return axios.get<UserRecord>('user');
}
  
export function logout() {
    return axios.delete('authorizations');
}
  