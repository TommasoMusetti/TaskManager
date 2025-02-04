import { defineStore } from 'pinia'

export const useSessionStore = defineStore('token', {
  state: () => ({
    token: '' as string,
    user: '' as string,
  }),
  actions: {
    setSession(newToken: string, newUser: string) {
      this.token = newToken
      this.user = newUser
    },
    clearSession() {
      this.token = ''
      this.user = ''
    },
  },
})
