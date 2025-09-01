<template>
  <div class="container mt-4">
    <h2 class="mb-4">Detail Employee</h2>

    <div v-if="!loaded" class="alert alert-secondary">Loading...</div>
    <div v-if="message" class="alert alert-danger">{{ message }}</div>

    <div v-if="loaded && employee" class="card p-3 shadow-sm">
      <div class="row">
        <div class="col-md-6 mb-3">
          <strong>Employee Number:</strong> {{ employee.employee_number }}
        </div>
        <div class="col-md-6 mb-3">
          <strong>Full Name:</strong> {{ employee.full_name }}
        </div>
        <div class="col-md-6 mb-3">
          <strong>Birth Place:</strong> {{ employee.birth_place }}
        </div>
        <div class="col-md-6 mb-3">
          <strong>Birth Date:</strong> {{ employee.birth_date }}
        </div>
        <div class="col-md-6 mb-3">
          <strong>Gender:</strong> {{ employee.gender }}
        </div>
        <div class="col-md-12 mb-3">
          <strong>Address:</strong> {{ employee.address }}
        </div>
        <div class="col-md-4 mb-3">
          <strong>Religion:</strong> {{ employee.religion?.name }}
        </div>
        <div class="col-md-4 mb-3">
          <strong>Position:</strong> {{ employee.employee_details?.position?.position_name }}
        </div>
        <div class="col-md-4 mb-3">
          <strong>Work Unit:</strong> {{ employee.employee_details?.work_unit?.unit_name }}
        </div>
        <div class="col-md-4 mb-3">
          <strong>Rank:</strong> {{ employee.employee_details?.rank }}
        </div>
        <div class="col-md-4 mb-3">
          <strong>Eselon:</strong> {{ employee.employee_details?.echelon }}
        </div>
        <div class="col-md-4 mb-3">
          <strong>Workplace:</strong> {{ employee.employee_details?.workplace }}
        </div>
        <div class="col-md-6 mb-3">
          <strong>Phone:</strong> {{ employee.employee_details?.phone_number }}
        </div>
        <div class="col-md-6 mb-3">
          <strong>Tax Number:</strong> {{ employee.employee_details?.tax_number }}
        </div>
        <div class="col-md-12 mb-3" v-if="employee.photo">
          <strong>Photo:</strong><br />
          <img :src="`http://localhost:8000/storage/${employee.photo}`"
               alt="Employee Photo"
               width="150"
               class="rounded shadow mt-2" />
        </div>
      </div>

      <div class="mt-3">
        <NuxtLink to="/employees" class="btn btn-secondary me-2">← Back</NuxtLink>
        <NuxtLink :to="`/employees/edit/${employee.id}`" class="btn btn-primary">Edit</NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"

const route = useRoute()
const employee = ref(null)
const loaded = ref(false)
const message = ref("")

onMounted(async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    const res = await $fetch(`http://localhost:8000/api/employees/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })

    employee.value = res
    loaded.value = true
  } catch (err) {
    console.error("Fetch error:", err)
    message.value = "Gagal load data employee"
  }
})
</script>
