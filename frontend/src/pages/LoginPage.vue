<template>
  <q-page class="flex flex-center">
    <q-card class="q-pa-md" style="width: 400px">
      <q-card-section>
        <div class="text-h5">Login</div>
      </q-card-section>

      <q-card-section>
        <q-form @submit="loginUser">
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
            :rules="[(val) => !!val || 'Campo Obbligatorio']"
          />

          <q-btn
            label="Login"
            type="submit"
            color="primary"
            class="full-width q-mt-md"
            :loading="loading"
          />
        </q-form>
      </q-card-section>
      <q-btn class="q-pa-md" label="Home" to="/"> </q-btn>
      <q-btn class="q-pa-md" label="Registrazione" to="/register"> </q-btn>
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

const form = ref({
  email: '',
  password: '',
})

const loading = ref(false)

const loginUser = async () => {
  loading.value = true

  try {
    const response = await axios.post('http://localhost:8000/api/login', form.value)
    if (response.status === 201) {
      $q.notify({
        message: response.data.message,
        color: 'green',
        icon: 'check',
        position: 'top',
      })
      localStorage.setItem('authToken', response.data.token)
      await router.push('/')
    } else {
      $q.notify({ message: 'Credenziali errate!' })
    }
  } catch (error) {
    console.log(error)
    $q.notify({ type: 'negative', message: 'Credenziali errate!' })
  }
  form.value = { email: '', password: '' }
  loading.value = false
}
</script>
