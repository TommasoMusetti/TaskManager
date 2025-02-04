<template>
  <q-page class="flex flex-center">
    <q-card>
      <q-card-section>
        <div class="text-h5 q-mb-lg">Benvenuto!</div>
      </q-card-section>
      <q-card-section class="flex" style="gap: 20px">
        <q-btn class="q-pa-md" label="Lista Task" to="/dashboard/tasks"></q-btn>
        <q-btn class="q-pa-md" label="Home" to="/"> </q-btn>
      </q-card-section>
    </q-card>
  </q-page>
</template>
<script setup lang="ts"></script>
