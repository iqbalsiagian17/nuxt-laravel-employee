<template>
  <div class="container mt-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 fw-bold">Dashboard</h1>
      <button class="btn btn-danger" @click="logout">Keluar</button>
    </div>

    <!-- Bagian Sambutan -->
    <div v-if="user" class="alert alert-success shadow-sm rounded-3">
      Selamat datang kembali, <strong>{{ user.name }}</strong>! 🎉
    </div>

    <!-- Bagian Pegawai -->
    <h4 class="mt-4 mb-3">Pegawai</h4>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-people-fill text-primary" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Pegawai</h5>
            <p class="card-text text-muted">Lihat dan kelola data pegawai.</p>
            <button class="btn btn-primary" @click="goToEmployees">Kelola Pegawai</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bagian Master Data -->
    <h4 class="mt-5 mb-3">Master Data</h4>
    <div class="row g-4">
      <!-- Agama -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-bookmark-fill text-success" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Agama</h5>
            <p class="card-text text-muted">Lihat dan kelola data agama.</p>
            <button class="btn btn-success" @click="goToReligion">Kelola Agama</button>
          </div>
        </div>
      </div>

      <!-- Jabatan -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-briefcase-fill text-warning" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Jabatan</h5>
            <p class="card-text text-muted">Lihat dan kelola data jabatan.</p>
            <button class="btn btn-warning text-white" @click="goToPosition">Kelola Jabatan</button>
          </div>
        </div>
      </div>

      <!-- Unit Kerja -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-building text-info" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Unit Kerja</h5>
            <p class="card-text text-muted">Lihat dan kelola data unit kerja.</p>
            <button class="btn btn-info text-white" @click="goToUnitWork">Kelola Unit Kerja</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { useRouter } from "vue-router";
import { ref, onMounted } from "vue";

const router = useRouter();
const user = ref(null);

onMounted(() => {
  const token = localStorage.getItem("token");
  if (!token) {
    router.push("/login");
    return;
  }

  try {
    const storedUser = localStorage.getItem("user");
    if (storedUser) user.value = JSON.parse(storedUser);
  } catch (err) {
    console.error("Gagal parse user:", err);
    localStorage.removeItem("user");
  }
});

const logout = () => {
  localStorage.removeItem("token");
  localStorage.removeItem("user");
  router.push("/login");
};

const goToEmployees = () => router.push("/employees");
const goToReligion = () => router.push("/masterdata/religion");
const goToPosition = () => router.push("/masterdata/position");
const goToUnitWork = () => router.push("/masterdata/unit-work");
</script>

<style>
body {
  background-color: #f8f9fa;
}

.card {
  transition: transform 0.2s;
}

.card:hover {
  transform: translateY(-5px);
}
</style>
