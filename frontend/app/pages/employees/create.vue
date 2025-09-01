<template>
  <div class="container mb-5 mt-5">
    <div class="card shadow-sm p-4">
      <h2 class="mb-4">Tambah Data Pegawai</h2>

      <form @submit.prevent="handleSubmit">
        <div class="row g-3">
          <!-- Nomor Pegawai -->
          <div class="col-md-6">
            <label class="form-label">Nomor Pegawai</label>
            <input v-model="form.employee_number" type="text" class="form-control" required />
          </div>

          <!-- Nama Lengkap -->
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input v-model="form.full_name" type="text" class="form-control" required />
          </div>

          <!-- Tempat Lahir -->
          <div class="col-md-6">
            <label class="form-label">Tempat Lahir</label>
            <input v-model="form.birth_place" type="text" class="form-control" required />
          </div>

          <!-- Tanggal Lahir -->
          <div class="col-md-6">
            <label class="form-label">Tanggal Lahir</label>
            <input v-model="form.birth_date" type="date" class="form-control" required />
          </div>

          <!-- Jenis Kelamin -->
          <div class="col-md-6">
            <label class="form-label d-block">Jenis Kelamin</label>
              <div class="d-flex gap-3">
                <RadioButton id="gender-m" name="gender" label="Laki-laki" value="M" v-model="form.gender" />
                <RadioButton id="gender-f" name="gender" label="Perempuan" value="F" v-model="form.gender" />
              </div>
          </div>

          <!-- Tempat Kerja -->
          <div class="col-md-6">
            <label class="form-label">Tempat Kerja</label>
            <ComboBox
              v-model="form.workplace"
              :options="[
                'Jakarta','Bandung', 'Bekasi', 'Bogor', 'Depok', 'Cirebon', 'Sukabumi', 'Tasikmalaya', 'Purwakarta',
                'Semarang', 'Solo', 'Surakarta', 'Magelang', 'Salatiga', 'Tegal', 'Kudus', 'Jepara',
                'Surabaya', 'Malang', 'Sidoarjo', 'Mojokerto', 'Banyuwangi', 'Bojonegoro', 'Probolinggo'
              ].map(city => ({ value: city, label: city }))"
              placeholder="-- Pilih Tempat Kerja --"
            />
          </div>

          <!-- Pangkat -->
          <div class="col-md-4">
            <label class="form-label">Golongan</label>
            <ComboBox
              v-model="form.rank"
              :options="[
                'I/a', 'I/b', 'I/c', 'I/d',
                'I/a', 'I/b', 'I/c', 'I/d',
                'II/a', 'II/b', 'II/c', 'II/d',
                'III/a', 'III/b', 'III/c', 'III/d',
                'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'
              ].map(g => ({ value: g, label: g }))"
              placeholder="-- Pilih Golongan --"
            />
          </div>

          <!-- Eselon -->
          <div class="col-md-4">
            <label class="form-label">Eselon</label>
            <ComboBox
              v-model="form.echelon"
              :options="[
                { value: '', label: '-- Kosong --' },
                'I', 'II', 'IIa', 'IIb', 
                'III', 'IIIa', 'IIIb', 
                'IV', 'IVa', 'IVb'
              ].map(e => ({ value: e, label: e }))"
              placeholder="-- Pilih Eselon --"
            />
          </div>

          <!-- Agama -->
          <div class="col-md-4">
            <label class="form-label">Agama</label>
            <ComboBox
              v-model="form.religion_id"
              :options="religions.map(r => ({ value: r.id, label: r.name }))"
              placeholder="-- Pilih Agama --"
            />
          </div>

          <!-- Jabatan -->
          <div class="col-md-4">
            <label class="form-label">Jabatan</label>
            <ComboBox
              v-model="form.position_id"
              :options="positions.map(p => ({ value: p.id, label: p.position_name }))"
              placeholder="-- Pilih Jabatan --"
            />
          </div>

          <!-- Unit Kerja -->
          <div class="col-md-4">
            <label class="form-label">Unit Kerja</label>
            <ComboBox
              v-model="form.work_unit_id"
              :options="workUnits.map(w => ({ value: w.id, label: w.unit_name }))"
              placeholder="-- Pilih Unit Kerja --"
            />
          </div>

          <!-- Alamat -->
          <div class="col-md-12">
            <label class="form-label">Alamat</label>
            <textarea v-model="form.address" class="form-control"></textarea>
          </div>

          <!-- Nomor Telepon -->
          <div class="col-md-6">
            <label class="form-label">Nomor Telepon</label>
            <input v-model="form.phone_number" type="text" class="form-control" />
          </div>

          <!-- Nomor Pajak -->
          <div class="col-md-6">
            <label class="form-label">Nomor Pajak</label>
            <input v-model="form.tax_number" type="text" class="form-control" />
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
          <NuxtLink to="/employees" class="btn btn-secondary">← Batal</NuxtLink>
          <button class="btn btn-primary">Simpan</button>
        </div>

      </form>

      <!-- Pesan -->
      <div v-if="message" class="alert alert-info mt-3">
        {{ message }}
      </div>
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
