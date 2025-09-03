<template>
  <div class="container mt-4">
    <div v-if="loaded" class="card shadow-sm p-4">
      <h2 class="mb-4">Edit Unit Kerja</h2>
      <form @submit.prevent="handleSubmit">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Unit Kerja</label>
            <input v-model="form.unit_name" type="text" class="form-control" required />
          </div>
        </div>
        <div class="mt-4 d-flex justify-content-end gap-2">
          <button class="btn btn-primary" type="submit">Update</button>
          <button class="btn btn-secondary" type="button" @click="goBack">Batal</button>
        </div>
      </form>
    </div>
    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>
    <div v-if="!loaded" class="alert alert-secondary mt-3">Loading...</div>
  </div>
</template>


<script setup>
import { ref, onMounted } from "vue"
import { useRouter, useRoute } from "vue-router"

const router = useRouter()
const route = useRoute()

const form = ref({ unit_name: "" })
const message = ref("")
const loaded = ref(false)

onMounted(async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    const res = await $fetch(`http://localhost:8000/api/work-units/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })

    const unitData = res.data || res
    form.value = { unit_name: unitData.unit_name }
    loaded.value = true
  } catch (err) {
    console.error("Fetch error:", err)
    message.value = "Gagal load data unit kerja"
  }
})

const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    await $fetch(`http://localhost:8000/api/work-units/${id}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })

    router.push("/masterdata/unit-work")
  } catch (err) {
    console.error(err)
    message.value = "Gagal update unit kerja!"
  }
}

const goBack = () => router.push("/masterdata/unit-work")
</script>
