<template>
  <div class="container mt-4">
    <h2 class="mb-4">Edit Agama</h2>

    <form v-if="loaded" @submit.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Agama</label>
          <input v-model="form.name" type="text" class="form-control" required />
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

const form = ref({ name: "" })
const message = ref("")
const loaded = ref(false)

onMounted(async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    const religion = await $fetch(`http://localhost:8000/api/religions/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })

    form.value = { name: religion.name }
    loaded.value = true
  } catch (err) {
    console.error("Fetch error:", err)
    message.value = "Gagal load data agama"
  }
})

const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    await $fetch(`http://localhost:8000/api/religions/${id}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })

    router.push("/masterdata/religion")
  } catch (err) {
    console.error(err)
    message.value = "Gagal update agama!"
  }
}

const goBack = () => router.push("/masterdata/religion")
</script>
