<template>
  <div class="container mt-4">
    <h2 class="mb-4">Edit Unit Kerja</h2>

    <form v-if="loaded" @submit.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Unit Kerja</label>
          <input v-model="form.unit_name" type="text" class="form-control" required />
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

    // Aman untuk semua struktur: langsung object atau object.data
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
