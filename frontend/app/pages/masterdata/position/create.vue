<template>
  <div class="container mt-4">
    <h2 class="mb-4">Tambah Jabatan</h2>

    <form @submit.prevent="handleSubmit">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Jabatan</label>
          <input v-model="form.position_name" type="text" class="form-control" required />
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

const form = ref({ position_name: "" })
const message = ref("")

const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    await $fetch("http://localhost:8000/api/positions", {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })
    router.push("/masterdata/position")
  } catch (err) {
    console.error(err)
    message.value = "Gagal menambahkan jabatan!"
  }
}

const goBack = () => router.push("/masterdata/position")
</script>
