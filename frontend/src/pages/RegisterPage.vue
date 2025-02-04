<template>
  <q-page class="flex flex-center">
    <q-card class="q-pa-md" style="width: 400px">
      <q-card-section>
        <div class="text-h5">Registrazione</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit="registerUser">
          <q-input
            filled
            v-model="form.name"
            label="Nome"
            :rules="[(val) => !!val || 'Campo obbligatorio']"
          />

          <q-input
            filled
            v-model="form.email"
            type="email"
            label="Email"
            :rules="[(val) => !!val || 'Campo obbligatorio']"
          />

          <q-input
            filled
            v-model="form.password"
            type="password"
            label="Password"
            :rules="[(val) => (val && val.length >= 6) || 'Minimo 6 caratteri']"
          />

          <q-input
            filled
            v-model="form.password_confirmation"
            type="password"
            label="Conferma Password"
            :rules="[(val) => val === form.password || 'Le password non corrispondono']"
          />

          <q-btn
            label="Registrati"
            type="submit"
            color="primary"
            class="full-width q-mt-md"
            :loading="loading"
          />
        </q-form> </q-card-section
      ><q-btn class="q-pa-md" label="Home" to="/"> </q-btn>
      <q-btn class="q-pa-md" label="Login" to="/login"> </q-btn>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'
import { useSessionStore } from 'src/stores/sessionStore'

const $q = useQuasar()
const router = useRouter()
const sessionStore = useSessionStore()
const loading = ref(false)
const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

function setSession(newToken: string, newUser: string) {
  sessionStore.setSession(newToken, newUser)
}

const registerUser = async () => {
  loading.value = true

  try {
    const response = await axios.post('http://localhost:8000/api/register', form.value)
    $q.notify({ message: response.data.message, color: 'green', icon: 'check', position: 'top' })
    form.value = { name: '', email: '', password: '', password_confirmation: '' }
    setSession(response.data.token, response.data.email)
    await router.push('/')
  } catch (error: unknown) {
    if (axios.isAxiosError(error)) {
      // Verifica se l'errore è un'istanza di AxiosError
      if (error.response && error.response.status === 422) {
        $q.notify({ message: 'Email già in uso' })
      } else {
        $q.notify({ message: 'Errore nella registrazione' })
      }
    } else {
      $q.notify({ message: 'Errore sconosciuto' })
    }
  }
  loading.value = false
}
</script>
