import {defineStore} from 'pinia';
import {
  authorizations,
  logout as userLogout,
  me
} from '@/api/auth';
import { removeRouteListener } from '@/utils/routeListener';

// @ts-ignore
const useUserStore = defineStore('user', {
    state: () => ({
      token: undefined,
      userInfo: {
        id: undefined,
        username: undefined,
        name: undefined,
        avatar: undefined,
        email: undefined,
      }
    }),
    persist: {
      paths: [
        'token'
      ]
    },
    actions: {
      async getUserInfo() {
        this.userInfo = await me();
      },
      // Login
      async login(loginData) {
        try {
          const res = await authorizations(loginData);
          
          this.setToken(res.access_token);
        } catch (err) {
          this.clearToken();
          throw err;
        }
      },
      // Logout
      async logout() {
        try {
          await userLogout();
        } finally {
          this.resetInfo();
          removeRouteListener();
        }
      },
      setToken(token: string) {
        this.token = token;
      },
      clearToken() {
        this.setToken(undefined);
      },
      resetInfo() {
        this.$reset();
      }
    }
  });
  
  export default useUserStore;
  