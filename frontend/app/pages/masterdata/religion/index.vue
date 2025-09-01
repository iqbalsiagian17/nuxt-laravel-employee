<template>
  <div class="container mt-5">
    <h1 class="h3 mb-4">Daftar Agama</h1>

    <!-- Toolbar -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div class="d-flex gap-2">
        <button class="btn btn-secondary" @click="goBack">← Kembali Dashboard</button>
        <button class="btn btn-success" @click="goCreate">+ Tambah Agama</button>
      </div>

      <div class="d-flex gap-2">
        <input
          type="text"
          v-model="search"
          placeholder="Cari nama agama..."
          class="form-control"
        />
      </div>
    </div>

    <!-- Loading / Table -->
    <div v-if="loading" class="alert alert-info">Loading...</div>
    <div v-else>
      <DataTable
        :columns="columns"
        :rows="religionsWithNo"
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

const religions = ref([]);
const loading = ref(true);
const api = useApi();
const router = useRouter();

const search = ref("");

// 👉 Fetch religions
const fetchReligions = async () => {
  loading.value = true;
  try {
    religions.value = await api("/religions");
  } catch (err) {
    console.error("Gagal fetch religions", err);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchReligions);

// 👉 Filter
const filteredReligions = computed(() =>
  religions.value.filter(r =>
    r.name.toLowerCase().includes(search.value.toLowerCase())
  )
);

const religionsWithNo = computed(() =>
  filteredReligions.value.map((r, index) => ({
    ...r,
    no: index + 1
  }))
);

// 👉 Columns
const columns = [
  { key: "no", label: "No" }, // nomor urut
  { key: "name", label: "Nama Agama" }
];

// 👉 Delete
const deleteReligion = async (id) => {
  if (!confirm("Yakin ingin menghapus agama ini?")) return;

  try {
    await api(`/religions/${id}`, { method: "DELETE" });
    await fetchReligions();
    alert("Agama berhasil dihapus");
  } catch (err) {
    console.error("Gagal hapus agama", err);
    alert("Gagal hapus agama!");
  }
};

// 👉 Actions table
const tableActions = [
  { name: "edit", label: "Edit", handler: row => goEdit(row.id) },
  { name: "delete", label: "Hapus", handler: row => deleteReligion(row.id) }
];

// 👉 Navigasi
const goBack = () => router.push("/dashboard");
const goCreate = () => router.push("/masterdata/religion/create");
const goEdit = id => router.push(`/masterdata/religion/edit/${id}`);
</script>
