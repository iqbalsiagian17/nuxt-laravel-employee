<template>
  <div class="container mt-4">
    <h2 class="mb-4">Edit Jabatan</h2>

    <form v-if="loaded" @submit.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Jabatan</label>
          <input v-model="form.position_name" type="text" class="form-control" required />
        </div>
      </div>

      <button class="btn btn-primary" type="submit">Update</button>
      <button class="btn btn-secondary ms-2" type="button" @click="goBack">Batal</button>
    </form>

    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>

    <div v-if="!loaded" class="alert alert-secondary">Loading...</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRouter, useRoute } from "vue-router"

const router = useRouter()
const route = useRoute()

const form = ref({ position_name: "" })
const message = ref("")
const loaded = ref(false)

onMounted(async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    const position = await $fetch(`http://localhost:8000/api/positions/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })

form.value = { position_name: position.data.position_name }
    loaded.value = true
  } catch (err) {
    console.error("Fetch error:", err)
    message.value = "Gagal load data jabatan"
  }
})

const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    await $fetch(`http://localhost:8000/api/positions/${id}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })

    router.push("/masterdata/position")
  } catch (err) {
    console.error(err)
    message.value = "Gagal update jabatan!"
  }
}

const goBack = () => router.push("/masterdata/position")
</script>
