<template>
  <div class="container mt-4">
    <h2 class="mb-4">Create Employee</h2>
    <form @submit.prevent="handleSubmit">
      <div class="row">
        <!-- Employee Number -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Employee Number</label>
          <input v-model="form.employee_number" type="text" class="form-control" required />
        </div>

        <!-- Full Name -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Full Name</label>
          <input v-model="form.full_name" type="text" class="form-control" required />
        </div>

        <!-- Birth Place -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Birth Place</label>
          <input v-model="form.birth_place" type="text" class="form-control" required />
        </div>

        <!-- Birth Date -->
        <div class="col-md-6 mb-3">
          <label class="form-label">Birth Date</label>
          <input v-model="form.birth_date" type="date" class="form-control" required />
        </div>

        <!-- Gender -->
        <div class="col-md-6 mb-3">
          <label class="form-label d-block">Gender</label>
          <RadioButton
            id="gender-m"
            name="gender"
            label="Male"
            value="M"
            v-model="form.gender"
          />
          <RadioButton
            id="gender-f"
            name="gender"
            label="Female"
            value="F"
            v-model="form.gender"
          />
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
      </div>

      <button class="btn btn-primary" type="submit">Save</button>
    </form>

    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()

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
  tax_number: ""
})

const message = ref("")
const religions = ref([])
const positions = ref([])
const workUnits = ref([])

// Fetch dropdown data (agama, jabatan, unit kerja)
onMounted(async () => {
  try {
    const token = localStorage.getItem("token")

    // Agama
    religions.value = await $fetch("http://localhost:8000/api/religions", {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` }
    })

    // Jabatan
    positions.value = (
      await $fetch("http://localhost:8000/api/positions", {
        method: "GET",
        headers: { Authorization: `Bearer ${token}` }
      })
    ).data

    // Unit Kerja (sudah nested children)
    workUnits.value = await $fetch("http://localhost:8000/api/work-units", {
      method: "GET",
      headers: { Authorization: `Bearer ${token}` }
    })
  } catch (err) {
    console.error("Fetch error:", err)
  }
})


// Submit
const handleSubmit = async () => {
  try {
    const token = localStorage.getItem("token")
    await $fetch("http://localhost:8000/api/employees", {
      method: "POST",
      headers: { Authorization: `Bearer ${token}` },
      body: form.value
    })
    router.push("/employees")
  } catch (err) {
    console.error(err)
    message.value = "Gagal menambahkan employee!"
  }
}
</script>
