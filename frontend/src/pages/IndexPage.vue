<template>
  <q-page class="flex flex-center" style="gap: 30px">
    <q-btn v-if="isLogged" class="q-pa-md" label="login" to="/login"> </q-btn>
    <q-btn v-else class="q-pa-md" label="Logout" @click="Logout"> </q-btn>
    <q-btn class="q-pa-md" label="dashboard" to="/tasks"></q-btn>
  </q-page>
</template>

<script setup lang="ts">
import { useSessionStore } from 'src/stores/sessionStore'
import { ref } from 'vue'

const sessionStore = useSessionStore()
const token = sessionStore.token

const isLogged = ref(token === '')

function Logout() {
  sessionStore.clearSession()
  isLogged.value = true
}
</script>
