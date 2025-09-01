<template>
  <div class="container mb-5 mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title mb-4">Edit Pegawai</h2>

        <form v-if="loaded" @submit.prevent="handleSubmit">
          <div class="row g-3">
            <!-- Employee Number -->
            <div class="col-md-6">
              <label class="form-label">Nomor Pegawai</label>
              <input v-model="form.employee_number" type="text" class="form-control" />
            </div>

            <!-- Full Name -->
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap</label>
              <input v-model="form.full_name" type="text" class="form-control" />
            </div>

            <!-- Birth Place -->
            <div class="col-md-6">
              <label class="form-label">Tempat Lahir</label>
              <input v-model="form.birth_place" type="text" class="form-control" />
            </div>

            <!-- Birth Date -->
            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir</label>
              <input v-model="form.birth_date" type="date" class="form-control" />
            </div>

            <!-- Gender -->
            <div class="col-md-6">
              <label class="form-label d-block">Jenis Kelamin</label>
              <div class="d-flex gap-3">
                <RadioButton id="gender-m" name="gender" label="Laki-laki" value="M" v-model="form.gender" />
                <RadioButton id="gender-f" name="gender" label="Perempuan" value="F" v-model="form.gender" />
              </div>
            </div>

            <!-- Workplace -->
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

            <!-- Rank -->
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

            <!-- Echelon -->
            <div class="col-md-4">
              <label class="form-label">Eselon</label>
              <ComboBox
                v-model="form.echelon"
                :options="[
                  { value: '', label: '-- Kosong --' }, // opsi kosong
                  'I', 'II', 'IIa', 'IIb', 
                  'III', 'IIIa', 'IIIb', 
                  'IV', 'IVa', 'IVb'
                ].map(e => typeof e === 'string' ? { value: e, label: e } : e)"
                placeholder="-- Pilih Eselon --"
              />
            </div>


            <!-- Religion -->
            <div class="col-md-4">
              <label class="form-label">Agama</label>
              <ComboBox
                v-model="form.religion_id"
                :options="religions.map(r => ({ value: r.id, label: r.name }))"
                placeholder="-- Pilih Agama --"
              />
            </div>

            <!-- Position -->
            <div class="col-md-4">
              <label class="form-label">Jabatan</label>
              <ComboBox
                v-model="form.position_id"
                :options="positions.map(p => ({ value: p.id, label: p.position_name }))"
                placeholder="-- Pilih Jabatan --"
              />
            </div>

            <!-- Work Unit -->
            <div class="col-md-4">
              <label class="form-label">Unit Kerja</label>
              <ComboBox
                v-model="form.work_unit_id"
                :options="workUnits.map(w => ({ value: w.id, label: w.unit_name }))"
                placeholder="-- Pilih Unit Kerja --"
              />
            </div>

            <!-- Address -->
            <div class="col-md-12">
              <label class="form-label">Alamat</label>
              <textarea v-model="form.address" class="form-control"></textarea>
            </div>

            <!-- Phone -->
            <div class="col-md-6">
              <label class="form-label">Nomor Telepon</label>
              <input v-model="form.phone_number" type="text" class="form-control" />
            </div>

            <!-- Tax -->
            <div class="col-md-6">
              <label class="form-label">Nomor Pajak</label>
              <input v-model="form.tax_number" type="text" class="form-control" />
            </div>

            <!-- Foto Pegawai -->
            <div class="col-md-12">
              <label class="form-label">Foto Pegawai</label>
              <input type="file" class="form-control mb-2" @change="handleFileChange" />
              <div v-if="form.photo" class="mt-2">
                <img :src="`http://localhost:8000/storage/${form.photo}`" alt="Foto Pegawai" width="150" class="rounded shadow" />
              </div>
              <button type="button" class="btn btn-warning mt-2" @click="uploadPhoto">Upload Foto</button>
            </div>
          </div>

          <!-- Tombol Batal & Simpan -->
          <div class="mt-4 d-flex justify-content-between">
            <NuxtLink to="/employees" class="btn btn-secondary">← Batal</NuxtLink>
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </form>

        <div v-if="message" class="alert alert-info mt-3">{{ message }}</div>
        <div v-if="!loaded" class="alert alert-secondary">Loading...</div>
      </div>
    </div>
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
