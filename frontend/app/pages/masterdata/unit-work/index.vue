<template>
  <div class="container mt-5">
    <h1 class="h3 mb-4">Daftar Unit Kerja</h1>
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div class="d-flex gap-2">
        <button class="btn btn-secondary" @click="goBack">← Back to Dashboard</button>
        <button class="btn btn-success" @click="goCreate">+ Tambah Unit Kerja</button>
      </div>

      <div class="d-flex gap-2">
        <input
          type="text"
          v-model="search"
          placeholder="Cari nama unit kerja..."
          class="form-control"
        />
      </div>
    </div>
    <div v-if="loading" class="alert alert-info">Loading...</div>
    <div v-else>
      <DataTable
        :columns="columns"
        :rows="unitsWithNo"
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

const units = ref([]);
const loading = ref(true);
const api = useApi();
const router = useRouter();

const search = ref("");
const fetchUnits = async () => {
  loading.value = true;
  try {
    const res = await api("/work-units");

    if (Array.isArray(res)) {
      units.value = res;
    } else if (res.data && Array.isArray(res.data)) {
      units.value = res.data;
    } else {
      units.value = [];
      console.warn("Unexpected API response:", res);
    }

  } catch (err) {
    console.error("Gagal fetch units", err);
    units.value = [];
  } finally {
    loading.value = false;
  }
};


onMounted(fetchUnits);

const filteredUnits = computed(() =>
  units.value.filter(u =>
    u.unit_name.toLowerCase().includes(search.value.toLowerCase())
  )
);

const unitsWithNo = computed(() =>
  filteredUnits.value.map((r, index) => ({
    ...r,
    no: index + 1
  }))
);

const columns = [
  { key: "no", label: "No" },
  { key: "unit_name", label: "Nama Unit Kerja" }
];

const deleteUnit = async (id) => {
  if (!confirm("Yakin ingin menghapus unit kerja ini?")) return;

  try {
    await api(`/work-units/${id}`, { method: "DELETE" }); 
    await fetchUnits();
    alert("Unit kerja berhasil dihapus");
  } catch (err) {
    console.error("Gagal hapus unit kerja", err);
    alert("Gagal hapus unit kerja!");
  }
};

const tableActions = [
  { name: "edit", label: "Edit", handler: row => goEdit(row.id) },
  { name: "delete", label: "Hapus", handler: row => deleteUnit(row.id) }
];

const goBack = () => router.push("/dashboard");
const goCreate = () => router.push("/masterdata/unit-work/create");
const goEdit = id => router.push(`/masterdata/unit-work/edit/${id}`);
</script>
