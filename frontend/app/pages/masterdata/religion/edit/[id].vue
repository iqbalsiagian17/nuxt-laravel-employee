<template>
    <div class="container mt-4">
        <div v-if="loaded" class="card shadow-sm p-4">
            <h2 class="mb-4">Edit Agama</h2>
            <form @submit.prevent="handleSubmit">
                <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Agama</label>
                    <input v-model="form.name" type="text" class="form-control" required />
                </div>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2">
                <button class="btn btn-primary" type="submit">Update</button>
                <button class="btn btn-secondary" type="button" @click="goBack">Batal</button>
                </div>
            </form>
            <div v-if="message" class="alert alert-info mt-3">
            {{ message }}
            </div>

            <div v-if="!loaded" class="alert alert-secondary">Loading...</div>
        </div>
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
