<template>
  <div class="container mb-5 mt-5">
    <h2 class="mb-4">Detail Pegawai</h2>

    <!-- Loading & Error -->
    <div v-if="!loaded" class="alert alert-secondary">Loading...</div>
    <div v-if="message" class="alert alert-danger">{{ message }}</div>

    <div v-if="loaded && employee" class="card shadow-sm p-4">
      <div class="row g-4 align-items-start">
    
        <!-- Informasi Pegawai -->
        <div class="col-md-9">
          <table class="table mb-0">
            <tbody>
              <tr>
                <th>Nomor Pegawai</th>
                <td>: {{ employee.employee_number }}</td>
              </tr>
              <tr>
                <th>Nama Lengkap</th>
                <td>: {{ employee.full_name }}</td>
              </tr>
              <tr>
                <th>Tempat / Tanggal Lahir</th>
                <td>: {{ employee.birth_place }} / {{ employee.birth_date }}</td>
              </tr>
              <tr>
                <th>Jenis Kelamin</th>
                <td>: {{ employee.gender === 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>: {{ employee.address }}</td>
              </tr>
              <tr>
                <th>Agama</th>
                <td>: {{ employee.religion?.name }}</td>
              </tr>
              <tr>
                <th>Jabatan</th>
                <td>: {{ employee.employee_details?.position?.position_name }}</td>
              </tr>
              <tr>
                <th>Unit Kerja</th>
                <td>: {{ employee.employee_details?.work_unit?.unit_name }}</td>
              </tr>
              <tr>
                <th>Pangkat</th>
                <td>: {{ employee.employee_details?.rank }}</td>
              </tr>
              <tr>
                <th>Eselon</th>
                <td>: {{ employee.employee_details?.echelon }}</td>
              </tr>
              <tr>
                <th>Tempat Kerja</th>
                <td>: {{ employee.employee_details?.workplace }}</td>
              </tr>
              <tr>
                <th>No. Telepon</th>
                <td>: {{ employee.employee_details?.phone_number }}</td>
              </tr>
              <tr>
                <th>No. Pajak</th>
                <td>: {{ employee.employee_details?.tax_number }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-3 text-center">
          <img
            v-if="employee.photo"
            :src="`http://localhost:8000/storage/${employee.photo}`"
            alt="Foto Pegawai"
            class="rounded shadow mb-3"
            style="width: 250px; height: 250px; object-fit: cover;"
          />
          <div v-else class="bg-secondary rounded shadow d-flex align-items-center justify-content-center" style="width:250px; height:250px;">
            <span class="text-white">No Photo</span>
          </div>
        </div>
      </div>
      

      <!-- Tombol Back & Edit -->
      <div class="mt-4 d-flex justify-content-between">
        <NuxtLink to="/employees" class="btn btn-secondary">← Kembali</NuxtLink>
        <NuxtLink :to="`/employees/edit/${employee.id}`" class="btn btn-primary">Edit</NuxtLink>
      </div>
    </div>
  </div>
</template>

<style>
.card {
  border-radius: 12px;
  background-color: #ffffff;
}

</style>



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
