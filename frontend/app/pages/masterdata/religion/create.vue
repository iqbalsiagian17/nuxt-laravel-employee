<template>
  <div class="container mt-4">
    <h2 class="mb-4">Tambah Agama</h2>

    <form @submit.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Agama</label>
          <input v-model="form.name" type="text" class="form-control" required />
        </div>
      </div>

      <button class="btn btn-primary" type="submit">Simpan</button>
      <button class="btn btn-secondary ms-2" type="button" @click="goBack">Batal</button>
    </form>

    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()

const form = ref({ name: "" })
const message = ref("")

const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    await $fetch("http://localhost:8000/api/religions", {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })
    router.push("/masterdata/religion")
  } catch (err) {
    console.error(err)
    message.value = "Gagal menambahkan agama!"
  }
}

const goBack = () => router.push("/masterdata/religion")
</script>
