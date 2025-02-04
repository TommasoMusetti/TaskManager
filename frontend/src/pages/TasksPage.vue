<template>
  <q-page class="flex flex-center">
    <q-card style="width: 600px">
      <q-card-section>
        <div class="text-h5 q-mb-lg">Benvenuto!</div>
      </q-card-section>

      <q-card-section> </q-card-section>

      <q-card-section style="gap: 20px">
        <q-form @submit="addTask" class="flex" style="gap: 20px">
          <q-btn
            label="Nuova Task"
            type="submit"
            color="primary"
            class="q-pa-none"
            style="width: 150px; height: 60px"
          />
          <q-input
            filled
            v-model="nuovaTask.descrizione"
            type="text"
            label="Task"
            style="width: 300px; height: 60px"
          />
        </q-form>
      </q-card-section>
      <q-card-section>
        <q-btn class="q-pa-md q-flex" label="Modifica Task" style="width: 150px; height: 60px" />
      </q-card-section>

      <q-card-section class="flex" style="gap: 20px">
        <q-btn class="q-pa-md" label="Completa Task" style="width: 150px; height: 60px" />
        <q-btn class="q-pa-md" label="Rimuovi Task" style="width: 150px; height: 60px" />
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { useQuasar } from 'quasar'
import axios from 'axios'
import { ref } from 'vue'

const nuovaTask = ref({
  descrizione: '',
})

const loading = ref(false)
const $q = useQuasar()

const addTask = async () => {
  loading.value = true

  try {
    const response = await axios.post(
      'http://localhost:8000/api/dashboard/tasks/addTask',
      nuovaTask.value,
    )
    nuovaTask.value = { descrizione: '' }
    $q.notify({ message: response.data.message })
  } catch (error) {
    console.log(error)
    $q.notify({ message: "Errore nell'aggiunta!" })
  }

  loading.value = false
}
</script>
