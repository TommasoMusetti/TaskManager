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
            :type="hidden_password ? 'password' : 'text'"
            label="Password"
            :rules="[(val) => (!!val && val.length >= 6) || 'Minimo 6 caratteri']"
          >
            <template v-slot:append>
              <q-icon
                :name="hidden_password ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="hidden_password = !hidden_password"
              />
            </template>
          </q-input>

          <q-input
            filled
            v-model="form.password_confirmation"
            :type="hidden_confirmed ? 'password' : 'text'"
            label="Conferma Password"
            :rules="[(val) => val === form.password || 'Le password non corrispondono']"
            ><template v-slot:append>
              <q-icon
                :name="hidden_confirmed ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="hidden_confirmed = !hidden_confirmed"
              /> </template
          ></q-input>

          <q-btn
            label="Registrati"
            type="submit"
            color="primary"
            class="full-width q-mt-md"
            :loading="loading"
          />
        </q-form>
      </q-card-section>
      <q-card-section class="flex" style="gap: 20px">
        <q-btn class="q-pa-md" label="Login" to="/login"> </q-btn>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'

const $q = useQuasar()
const router = useRouter()
const loading = ref(false)
const hidden_password = ref(true)
const hidden_confirmed = ref(true)
const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

function setSession(newToken: string, newUser: string, newUsername: string) {
  const session = { user: newUser, token: newToken, username: newUsername }
  localStorage.setItem('session', JSON.stringify(session))
}

const registerUser = async () => {
  loading.value = true

  try {
    const response = await axios.post('http://localhost:8000/api/register', form.value)
    $q.notify({ message: response.data.message, color: 'green', icon: 'check', position: 'top' })
    form.value = { name: '', email: '', password: '', password_confirmation: '' }
    setSession(response.data.token, response.data.email, response.data.username)
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
