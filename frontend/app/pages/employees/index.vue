<template>
  <div class="container mt-5">
    <h1 class="h3 mb-4">Daftar Pegawai</h1>

    <!-- Toolbar -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div class="d-flex gap-2">
        <button class="btn btn-secondary" @click="goBack">← Kembali ke Dashboard</button>
        <button class="btn btn-success" @click="goCreate">+ Tambah Pegawai</button>
        <button class="btn btn-outline-primary" @click="printPdf">🖨 Cetak PDF</button>
      </div>

      <div class="d-flex gap-2">
        <input type="text" v-model="search" placeholder="Cari nama..." class="form-control" />
        <select v-model="selectedUnit" class="form-select">
          <option value="">Semua Unit</option>
          <option v-for="unit in workUnits" :key="unit" :value="unit">{{ unit }}</option>
        </select>
      </div>
    </div>

    <!-- Tabel Data -->
    <div v-if="loading" class="alert alert-info">Memuat data...</div>
    <div v-if="message" class="alert alert-danger">{{ message }}</div>
    <div v-else>
      <DataTable
        :columns="columns"
        :rows="employeesWithNo"
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


const employees = ref([]);
const loading = ref(true);
const api = useApi();
const router = useRouter();

const search = ref("");
const selectedUnit = ref("");

const fetchEmployees = async () => {
  loading.value = true;
  try {
    employees.value = await api("/employees");
  } catch (err) {
    console.error("Gagal fetch employees", err);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchEmployees);

const workUnits = computed(() => {
  const units = employees.value
    .map(e => e.employee_details?.work_unit?.unit_name)
    .filter(Boolean);
  return [...new Set(units)];
});

const filteredEmployees = computed(() =>
  employees.value.filter(emp => {
    const matchSearch = !search.value || emp.full_name?.toLowerCase().includes(search.value.toLowerCase());
    const matchUnit = !selectedUnit.value || emp.employee_details?.work_unit?.unit_name === selectedUnit.value;
    return matchSearch && matchUnit;
  })
);

const employeesWithNo = computed(() =>
  filteredEmployees.value.map((emp, index) => ({
    ...emp,
    no: index + 1,
    gender_display: emp.gender === "M" ? "L" : emp.gender === "F" ? "P" : "-"
  }))
);

const columns = [
  { key: "no", label: "No." }, 
  { key: "employee_number", label: "NIP" },
  { key: "full_name", label: "Nama" },
  { key: "birth_place", label: "Tempat Lahir" },
  { key: "address", label: "Alamat" },
  { key: "birth_date", label: "Tgl Lahir" },
  { key: "gender_display", label: "L/P" },
  { key: "employee_details.rank", label: "Gol" },
  { key: "employee_details.echelon", label: "Eselon" },
  { key: "employee_details.position.position_name", label: "Jabatan" },
  { key: "employee_details.workplace", label: "Tempat Tugas" },
  { key: "religion.name", label: "Agama" },
  { key: "employee_details.work_unit.unit_name", label: "Unit Kerja" },
  { key: "employee_details.phone_number", label: "No. HP" },
  { key: "employee_details.tax_number", label: "NPWP" }
];

const deleteEmployee = async (id) => {
  if (!confirm("Yakin ingin menghapus employee ini?")) return;

  try {
    await api(`/employees/${id}`, {
      method: "DELETE"
    });
    await fetchEmployees();
    alert("Employee berhasil dihapus");
  } catch (err) {
    console.error("Gagal hapus employee", err);
    alert("Gagal hapus employee!");
  }
};

const tableActions = [
  { name: "view", label: "View", handler: row => goDetail(row.id) },
  { name: "edit", label: "Edit", handler: row => goEdit(row.id) },
  { name: "delete", label: " Hapus", handler: row => deleteEmployee(row.id) }
];

const goBack = () => router.push("/dashboard");
const goCreate = () => router.push("/employees/create");
const goEdit = id => router.push(`/employees/edit/${id}`);
const goDetail = id => router.push(`/employees/detail/${id}`);

const printPdf = async () => {
  if (!process.client) return;

  const { jsPDF } = await import("jspdf");
  const autoTable = (await import("jspdf-autotable")).default;

  const doc = new jsPDF({
    orientation: "landscape", 
    unit: "pt",
    format: "a4"
  });

  doc.setFontSize(14);
  doc.text("DAFTAR PEGAWAI", 40, 30);

  const tableColumn = columns.map(c => c.label);

  const tableRows = filteredEmployees.value.map((emp, index) => {
    return columns.map((c, colIndex) => {
      if (colIndex === 0) return index + 1; // No. urut
      if (c.key === "gender") return emp.gender === "M" ? "L" : emp.gender === "F" ? "P" : "-";
      return c.key.split(".").reduce((acc, part) => acc?.[part] ?? "-", emp);
    });
  });

  autoTable(doc, {
    startY: 50,
    head: [tableColumn],
    body: tableRows,
    styles: { fontSize: 10 },
    headStyles: { fillColor: [52, 73, 94] },
    theme: "grid"
  });

  doc.save("daftar-employees.pdf");
};


</script>
