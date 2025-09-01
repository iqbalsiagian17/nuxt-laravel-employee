<template>
  <div class="container mt-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 fw-bold"> Dashboard</h1>
      <button class="btn btn-danger" @click="logout">Logout</button>
    </div>

    <!-- Welcome Section -->
    <div v-if="user" class="alert alert-success shadow-sm rounded-3">
      Selamat datang kembali, <strong>{{ user.name }}</strong>! 🎉
    </div>

    <!-- Employees Section -->
    <h4 class="mt-4 mb-3">Pegawai</h4>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-people-fill text-primary" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Employees</h5>
            <p class="card-text text-muted">Lihat dan kelola data pegawai.</p>
            <button class="btn btn-primary" @click="goToEmployees">Go to Employees</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Master Data Section -->
    <h4 class="mt-5 mb-3">Master Data</h4>
    <div class="row g-4">
      <!-- Religion -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-bookmark-fill text-success" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Agama</h5>
            <p class="card-text text-muted">Lihat dan kelola data agama.</p>
            <button class="btn btn-success" @click="goToReligion">Go to Agama</button>
          </div>
        </div>
      </div>

      <!-- Position -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-briefcase-fill text-warning" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Jabatan</h5>
            <p class="card-text text-muted">Lihat dan kelola data jabatan.</p>
            <button class="btn btn-warning text-white" @click="goToPosition">Go to Jabatan</button>
          </div>
        </div>
      </div>

      <!-- Unit Work -->
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <div class="mb-3">
              <i class="bi bi-building text-info" style="font-size: 2.5rem;"></i>
            </div>
            <h5 class="card-title fw-bold">Unit Kerja</h5>
            <p class="card-text text-muted">Lihat dan kelola data Unit Kerja.</p>
            <button class="btn btn-info text-white" @click="goToUnitWork">Go to Unit Kerja</button>
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
const goToUnitWork = () => router.push("/masterdata/unit");
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
