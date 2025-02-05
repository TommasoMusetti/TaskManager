<template>
  <q-page class="flex flex-center" style="gap: 30px; padding: 20px">
    <q-card class="shadow-2" style="min-width: 300px; padding: 20px">
      <q-btn
        v-if="isLogged"
        class="q-pa-md"
        label="Login"
        color="primary"
        to="/login"
        style="width: 100%"
      />
      <q-card v-else class="flex flex-column" style="gap: 20px">
        <q-btn
          class="q-pa-md"
          label="Logout"
          color="negative"
          @click="Logout"
          style="width: 100%"
        />
        <q-btn
          class="q-pa-md"
          label="Dashboard"
          color="secondary"
          to="/tasks"
          style="width: 100%"
        />
      </q-card>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const session = localStorage.getItem('session')
const parsedSession = session ? JSON.parse(session) : null

const isLogged = ref(parsedSession?.token === '')

function Logout() {
  localStorage.removeItem('session')
  isLogged.value = true
}
</script>
