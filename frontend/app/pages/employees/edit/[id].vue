<template>
  <div class="container mt-4">
    <h2 class="mb-4">Edit Employee</h2>

    <form v-if="loaded" @submit.prevent="handleSubmit">
      <div class="row">
        <!-- Employee Number -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Employee Number</label>
          <input v-model="form.employee_number" type="text" class="form-control" />
        </div>

        <!-- Full Name -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Full Name</label>
          <input v-model="form.full_name" type="text" class="form-control" />
        </div>

        <!-- Birth Place -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Birth Place</label>
          <input v-model="form.birth_place" type="text" class="form-control" />
        </div>

        <!-- Birth Date -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Birth Date</label>
          <input v-model="form.birth_date" type="date" class="form-control" />
        </div>

        <!-- Gender -->
        <div class="col-md-6 mb-3">
          <label class="form-label d-block">Gender</label>
          <RadioButton id="gender-m" name="gender" label="Male" value="M" v-model="form.gender" />
          <RadioButton id="gender-f" name="gender" label="Female" value="F" v-model="form.gender" />
        </div>

        <!-- Workplace -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Workplace</label>
          <input v-model="form.workplace" type="text" class="form-control" />
        </div>

        <!-- Rank -->
        <div class="col-md-4 mb-3">
          <label class="form-label">Rank</label>
          <input v-model="form.rank" type="text" class="form-control" />
        </div>

        <!-- Echelon -->
        <div class="col-md-4 mb-3">
          <label class="form-label">Echelon</label>
          <input v-model="form.echelon" type="text" class="form-control" />
        </div>

        <!-- Religion -->
        <div class="col-md-4 mb-3">
          <ComboBox
            v-model="form.religion_id"
            :options="religions.map(r => ({ value: r.id, label: r.name }))"
            placeholder="-- Pilih Agama --"
            label="Religion"
          />
        </div>

        <!-- Position -->
        <div class="col-md-4 mb-3">
          <ComboBox
            v-model="form.position_id"
            :options="positions.map(p => ({ value: p.id, label: p.position_name }))"
            placeholder="-- Pilih Jabatan --"
            label="Position"
          />
        </div>

        <!-- Work Unit -->
        <div class="col-md-4 mb-3">
          <ComboBox
            v-model="form.work_unit_id"
            :options="workUnits.map(w => ({ value: w.id, label: w.unit_name }))"
            placeholder="-- Pilih Unit Kerja --"
            label="Work Unit"
          />
        </div>

        <!-- Address -->
        <div class="col-md-12 mb-3">
          <label class="form-label">Address</label>
          <textarea v-model="form.address" class="form-control"></textarea>
        </div>

        <!-- Phone -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Phone Number</label>
          <input v-model="form.phone_number" type="text" class="form-control" />
        </div>

        <!-- Tax -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Tax Number</label>
          <input v-model="form.tax_number" type="text" class="form-control" />
        </div>

        <!-- Foto Pegawai -->
        <div class="col-md-12 mb-3">
          <label class="form-label">Foto Pegawai</label>
          <input type="file" class="form-control mb-2" @change="handleFileChange" />
          <div v-if="form.photo" class="mt-2">
            <img :src="`http://localhost:8000/storage/${form.photo}`" alt="Employee Photo" width="150" class="rounded shadow" />
          </div>
          <button type="button" class="btn btn-warning mt-2" @click="uploadPhoto">Upload Foto</button>
        </div>
      </div>

      <button class="btn btn-primary" type="submit">Update</button>
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

const form = ref({
  employee_number: "",
  full_name: "",
  birth_place: "",
  birth_date: "",
  gender: "",
  workplace: "",
  rank: "",
  echelon: "",
  address: "",
  religion_id: "",
  position_id: "",
  work_unit_id: "",
  phone_number: "",
  tax_number: "",
  photo: "" // tambahkan untuk preview foto
})

const message = ref("")
const religions = ref([])
const positions = ref([])
const workUnits = ref([])
const loaded = ref(false)
const selectedFile = ref(null)

onMounted(async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    // fetch master data
    religions.value = await $fetch("http://localhost:8000/api/religions", {
      headers: { Authorization: `Bearer ${token}` }
    })
    positions.value = (await $fetch("http://localhost:8000/api/positions", {
      headers: { Authorization: `Bearer ${token}` }
    })).data
    workUnits.value = await $fetch("http://localhost:8000/api/work-units", {
      headers: { Authorization: `Bearer ${token}` }
    })

    // fetch employee detail
    const emp = await $fetch(`http://localhost:8000/api/employees/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })

    form.value = {
      employee_number: emp.employee_number ?? "",
      full_name: emp.full_name ?? "",
      birth_place: emp.birth_place ?? "",
      birth_date: emp.birth_date ?? "",
      gender: emp.gender ?? "",
      workplace: emp.employee_details?.workplace ?? "",
      rank: emp.employee_details?.rank ?? "",
      echelon: emp.employee_details?.echelon ?? "",
      address: emp.address ?? "",
      religion_id: emp.religion_id ?? "",
      position_id: emp.employee_details?.position_id ?? "",
      work_unit_id: emp.employee_details?.work_unit_id ?? "",
      phone_number: emp.employee_details?.phone_number ?? "",
      tax_number: emp.employee_details?.tax_number ?? "",
      photo: emp.photo ?? ""
    }

    loaded.value = true
  } catch (err) {
    console.error("Fetch error:", err)
    message.value = "Gagal load data employee"
  }
})

const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    const id = route.params.id

    await $fetch(`http://localhost:8000/api/employees/${id}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })

    router.push("/employees")
  } catch (err) {
    console.error(err)
    message.value = "Gagal update employee!"
  }
}

// handle pilih file
const handleFileChange = (event) => {
  selectedFile.value = event.target.files[0]
}

// upload foto
const uploadPhoto = async () => {
  if (!selectedFile.value) {
    message.value = "Silakan pilih foto terlebih dahulu"
    return
  }

  try {
    const token = localStorage.getItem("token")
    const id = route.params.id
    const formData = new FormData()
    formData.append("photo", selectedFile.value)

    const res = await $fetch(`http://localhost:8000/api/employees/${id}/upload-photo`, {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
      body: formData
    })

    form.value.photo = res.data.photo
    message.value = "Foto berhasil diupload!"
  } catch (err) {
    console.error("Upload error:", err)
    message.value = "Gagal upload foto!"
  }
}
</script>
