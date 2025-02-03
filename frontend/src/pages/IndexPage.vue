<template>
  <q-page class="flex flex-center">
    <q-btn v-if="isLogged" class="q-pa-md" label="login" to="/login"> </q-btn>
    <q-btn v-else class="q-pa-md" label="Logout" @click="Logout"> </q-btn>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const isLogged = ref(localStorage.getItem('authToken') === null)

function Logout() {
  localStorage.removeItem('authToken')
  isLogged.value = true
}
</script>
