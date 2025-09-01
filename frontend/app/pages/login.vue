<template>
  <div class="d-flex vh-100 align-items-center justify-content-center bg-light">
    <div class="card shadow-lg p-4" style="width: 400px;">
      <h3 class="text-center mb-4">Login</h3>
      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input v-model="email" type="email" class="form-control" placeholder="Enter email" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input v-model="password" type="password" class="form-control" placeholder="Enter password" required />
        </div>
        <button class="btn btn-primary w-100" type="submit">
          Login
        </button>
      </form>
      <p v-if="error" class="text-danger mt-3 text-center">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"

const email = ref("")
const password = ref("")
const error = ref("")
const router = useRouter()

const handleLogin = async () => {
  try {
    const response = await $fetch("http://localhost:8000/api/login", {
      method: "POST",
      body: { email: email.value, password: password.value }
    })

    if (response?.token) {
      localStorage.setItem("token", response.token)
      router.push("/dashboard")
    } else {
      error.value = "Login gagal, periksa email/password!"
    }
  } catch (err) {
    error.value = "Terjadi kesalahan!"
  }
}
</script>
