<template>
  <div class="card shadow-sm p-3">
    <h5 class="card-title">Upload File</h5>
    <form @submit.prevent="uploadFile">
      <!-- Input file -->
      <div class="mb-3">
        <label for="file" class="form-label">Pilih File</label>
        <input
          type="file"
          id="file"
          class="form-control"
          @change="handleFileChange"
        />
      </div>

      <!-- Progress -->
      <div v-if="progress > 0" class="progress mb-3">
        <div
          class="progress-bar"
          role="progressbar"
          :style="{ width: progress + '%' }"
          :aria-valuenow="progress"
          aria-valuemin="0"
          aria-valuemax="100"
        >
          {{ progress }}%
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary" :disabled="loading">
        <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
        Upload
      </button>
    </form>

    <!-- Success / Error message -->
    <div v-if="message" class="alert alert-info mt-3">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const file = ref(null);
const progress = ref(0);
const loading = ref(false);
const message = ref("");

const handleFileChange = (event) => {
  file.value = event.target.files[0];
};

const uploadFile = async () => {
  if (!file.value) {
    message.value = "Silakan pilih file terlebih dahulu.";
    return;
  }

  const formData = new FormData();
  formData.append("file", file.value);

  loading.value = true;
  message.value = "";
  progress.value = 0;

  try {
    const response = await fetch("http://127.0.0.1:8000/api/upload", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) throw new Error("Upload gagal");

    message.value = "File berhasil diupload!";
  } catch (error) {
    message.value = "Terjadi kesalahan saat upload.";
  } finally {
    loading.value = false;
    progress.value = 100;
  }
};
</script>
