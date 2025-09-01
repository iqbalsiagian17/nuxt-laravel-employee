<template>
  <div class="container mt-5">
    <h1 class="h3 mb-4">Daftar Jabatan</h1>

    <!-- Toolbar -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div class="d-flex gap-2">
        <button class="btn btn-secondary" @click="goBack">← Back to Dashboard</button>
        <button class="btn btn-success" @click="goCreate">+ Tambah Jabatan</button>
      </div>

      <div class="d-flex gap-2">
        <input
          type="text"
          v-model="search"
          placeholder="Cari nama jabatan..."
          class="form-control"
        />
      </div>
    </div>

    <!-- Loading / Table -->
    <div v-if="loading" class="alert alert-info">Loading...</div>
    <div v-else>
      <DataTable
        :columns="columns"
        :rows="positionsWithNo"
        :perPage="10"
        :actions="tableActions"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useApi } from "~/composables/useApi";
import DataTable from "~/components/DataTable.vue";

const positions = ref([]);
const loading = ref(true);
const api = useApi();
const router = useRouter();

const search = ref("");

// 👉 Fetch positions
const fetchPositions = async () => {
  loading.value = true;
  try {
    const res = await api("/positions");
    positions.value = res.data || []; 
  } catch (err) {
    console.error("Gagal fetch positions", err);
    positions.value = [];
  } finally {
    loading.value = false;
  }
};

onMounted(fetchPositions);

// 👉 Filter
const filteredPositions = computed(() =>
  positions.value.filter(p =>
    p.position_name.toLowerCase().includes(search.value.toLowerCase())
  )
);


const positionsWithNo = computed(() =>
  filteredPositions.value.map((r, index) => ({
    ...r,
    no: index + 1
  }))
);

// 👉 Columns
const columns = [
  { key: "no", label: "No" },
  { key: "position_name", label: "Nama Jabatan" }
];

// 👉 Delete
const deletePosition = async (id) => {
  if (!confirm("Yakin ingin menghapus jabatan ini?")) return;

  try {
    await api(`/positions/${id}`, { method: "DELETE" });
    await fetchPositions();
    alert("Jabatan berhasil dihapus");
  } catch (err) {
    console.error("Gagal hapus jabatan", err);
    alert("Gagal hapus jabatan!");
  }
};


// 👉 Actions table
const tableActions = [
  { name: "edit", label: "Edit", handler: row => goEdit(row.id) },
  { name: "delete", label: "Hapus", handler: row => deletePosition(row.id) }
];

// 👉 Navigasi
const goBack = () => router.push("/dashboard");
const goCreate = () => router.push("/masterdata/position/create");
const goEdit = id => router.push(`/masterdata/position/edit/${id}`);
</script>
