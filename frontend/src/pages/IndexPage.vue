<template>
  <q-page class="flex flex-center" style="gap: 30px">
    <q-btn v-if="isLogged" class="q-pa-md" label="login" to="/login"> </q-btn>
    <q-btn v-else class="q-pa-md" label="Logout" @click="Logout"> </q-btn>
    <q-btn class="q-pa-md" label="dashboard" to="/dashboard"></q-btn>
  </q-page>
</template>

<script setup lang="ts">
import { useTokenStore } from 'src/stores/tokenStore'
import { ref } from 'vue'

const tokenStore = useTokenStore()
const token = tokenStore.token

const isLogged = ref(token === '')

function Logout() {
  tokenStore.clearToken()
  isLogged.value = true
}
</script>
