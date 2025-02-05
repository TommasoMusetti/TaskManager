<template>
  <q-page class="flex flex-center">
    <q-card style="max-width: 90%; width: 600px; padding: 20px">
      <q-card-section>
        <div class="text-h5">Benvenuto {{ parsedUser?.username }}!</div>
      </q-card-section>

      <q-card-section>
        <q-list bordered>
          <q-item
            v-for="task in listaTask"
            :key="task.id"
            :class="{ completata: task.checked === 1 }"
          >
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
            style="width: 150px; height: 60px; transition: all 0.3s ease"
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
            style="width: 150px; height: 60px; transition: all 0.3s ease"
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

      <q-card-section class="flex" style="justify-content: space-between; margin-top: 40px">
        <q-btn
          label="Completa Task"
          color="positive"
          class="q-pa-md"
          style="width: 150px; height: 60px; transition: all 0.3s ease"
          @click="completeTask"
        />
        <q-btn
          label="Rimuovi Task"
          color="negative"
          class="q-pa-md"
          style="width: 150px; height: 60px; transition: all 0.3s ease"
          @click="removeTask"
        />
      </q-card-section>
    </q-card>
    <q-btn
      class="q-pa-md"
      label="Logout"
      color="negative"
      style="width: 150px; height: 60px; position: absolute; top: 40px; right: 40px"
      @click="confirmLogout"
    />
  </q-page>
</template>

<script setup lang="ts">
import { useQuasar } from 'quasar'
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const loading = ref(false)
const $q = useQuasar()
const router = useRouter()
const user = localStorage.getItem('session') ?? '{}'
const parsedUser = JSON.parse(user)
const selectedTasks = ref([])

const nuovaTask = ref({
  descrizione: '',
  user_email: parsedUser?.user,
})

const modificaTask = ref({
  descrizione: '',
})

const listaTask = ref([
  {
    id: 0,
    descrizione: '',
    checked: 0,
  },
])

const fetchTasks = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/tasks/viewTask', {
      email: parsedUser?.user,
    })
    listaTask.value = response.data
    selectedTasks.value = []
  } catch (error) {
    console.log(error)
  }
}

onMounted(fetchTasks)

const addTask = async () => {
  loading.value = true

  try {
    const response = await axios.post('http://localhost:8000/api/tasks/addTask', nuovaTask.value)
    nuovaTask.value = { descrizione: '', user_email: parsedUser?.user }
    $q.notify({ message: response.data.message })
    await fetchTasks()
  } catch (error) {
    console.log(error)
    $q.notify({ message: "Errore nell'aggiunta!" })
  }

  loading.value = false
}

const changeTask = async () => {
  try {
    if (selectedTasks.value.length < 2) {
      const response = await axios.put('http://localhost:8000/api/tasks/changeTask', {
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

const completeTask = async () => {
  try {
    const response = await axios.put('http://localhost:8000/api/tasks/completeTask', {
      ids: selectedTasks.value,
    })
    $q.notify({ message: response.data.message })
    await fetchTasks()
  } catch (error) {
    console.log(error)
    $q.notify({ message: 'Errore nella modifica!' })
  }
}

const removeTask = async () => {
  try {
    const response = await axios.delete('http://localhost:8000/api/tasks/removeTask', {
      params: { ids: selectedTasks.value },
    })
    $q.notify({ message: response.data.message })
    await fetchTasks()
  } catch (error) {
    console.log(error)
    $q.notify({ message: 'Errore nella eliminazione!' })
  }
}

function confirmLogout() {
  $q.dialog({
    title: 'Confirm Logout',
    message: 'Confermi di voler uscire?',
    cancel: true,
    persistent: true,
  })
    .onOk(() => {
      localStorage.removeItem('session')
      void router.push('/')
    })
    .onCancel(() => {
      console.log("L'utente ha deciso di non uscire")
    })
}
</script>

<style scoped>
.completata {
  text-decoration: line-through;
  opacity: 0.6;
  background-color: #f0f0f0;
}

.q-btn {
  transition: all 0.3s ease;
}

.q-btn:hover {
  background-color: #3b82f6;
}
</style>
