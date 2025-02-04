<template>
  <q-page class="flex flex-center">
    <q-card style="width: 600px">
      <q-card-section>
        <div class="text-h5">Benvenuto!</div>
      </q-card-section>

      <q-card-section>
        <q-list bordered>
          <q-item v-for="task in listaTask" :key="task.id">
            <q-item-section avatar>
              <input type="checkbox" v-model="selectedTasks" :value="task.id" />
            </q-item-section>
            <q-item-section> {{ task.descrizione }} </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>

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

      <q-card-section style="gap: 20px">
        <q-form @submit="changeTask" class="flex" style="gap: 20px">
          <q-btn
            label="Modifica Task"
            type="submit"
            color="primary"
            class="q-pa-none"
            style="width: 150px; height: 60px"
          />
          <q-input
            filled
            v-model="modificaTask.descrizione"
            type="text"
            label="Task"
            style="width: 300px; height: 60px"
          />
        </q-form>
      </q-card-section>

      <q-card-section class="flex" style="gap: 20px">
        <q-btn
          label="Completa Task"
          color="primary"
          class="q-pa-md"
          style="width: 150px; height: 60px"
        />
        <q-btn
          label="Rimuovi Task"
          color="primary"
          class="q-pa-md"
          style="width: 150px; height: 60px"
        />
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { useQuasar } from 'quasar'
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useSessionStore } from 'src/stores/sessionStore'

const loading = ref(false)
const $q = useQuasar()
const sessionStore = useSessionStore()

const user = sessionStore.user
const selectedTasks = ref([])

const nuovaTask = ref({
  descrizione: '',
  user_email: user,
})

const modificaTask = ref({
  descrizione: '',
})

const listaTask = ref([
  {
    id: 0,
    descrizione: '',
  },
])

const addTask = async () => {
  loading.value = true

  try {
    const response = await axios.post(
      'http://localhost:8000/api/dashboard/tasks/addTask',
      nuovaTask.value,
    )
    nuovaTask.value = { descrizione: '', user_email: user }
    $q.notify({ message: response.data.message })
    await fetchTasks()
  } catch (error) {
    console.log(error)
    $q.notify({ message: "Errore nell'aggiunta!" })
  }

  loading.value = false
}

const fetchTasks = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/dashboard/tasks/viewTask', {
      email: user,
    })
    listaTask.value = response.data
  } catch (error) {
    console.log(error)
  }
}

onMounted(fetchTasks)

const changeTask = async () => {
  try {
    if (selectedTasks.value.length < 2) {
      const response = await axios.post('http://localhost:8000/api/dashboard/tasks/changeTask', {
        task: modificaTask.value,
        id: selectedTasks.value[0],
      })
      modificaTask.value = { descrizione: '' }
      $q.notify({ message: response.data.message })
      await fetchTasks()
    } else {
      modificaTask.value = { descrizione: '' }
      $q.notify({ message: 'Puoi modificare solo una task alla volta!' })
    }
  } catch (error) {
    console.log(error)
    $q.notify({ message: "Errore nell'aggiunta!" })
  }
}
</script>
