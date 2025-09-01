<template>
  <div class="container mt-4">
    <div v-if="loaded" class="card shadow-sm p-4">
      <h2 class="mb-4">Edit Jabatan</h2>
        <form @submit.prevent="handleSubmit">
          <div class="row g-3">
            <!-- Nama Jabatan -->
            <div class="col-md-6">
              <label class="form-label">Nama Jabatan</label>
              <input v-model="form.position_name" type="text" class="form-control" required />
            </div>
          </div>

          <!-- Tombol Update & Batal -->
          <div class="mt-4 d-flex justify-content-end gap-2">
            <button class="btn btn-primary" type="submit">Update</button>
            <button class="btn btn-secondary" type="button" @click="goBack">Batal</button>
          </div>
        </form>
      </div>
      <!-- Pesan Informasi -->
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
