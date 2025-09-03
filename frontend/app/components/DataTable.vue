<template>
  <div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th v-for="col in columns" :key="col.key">{{ col.label }}</th>
            <th v-if="actions.length" class="text-center">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="row in paginatedRows" :key="row.id">
            <td v-for="col in columns" :key="col.key">
              {{ getValue(row, col.key) }}
            </td>

            <td v-if="actions.length" class="text-center">
              <div class="dropdown position-static">
                <button
                  class="btn btn-sm btn-light border-0"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  ⋮
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                  <li v-for="act in actions" :key="act.name">
                    <button
                      class="dropdown-item d-flex align-items-center gap-2"
                      @click.prevent="act.handler(row)"
                      :title="act.tooltip || act.label"
                    >
                      <i :class="act.icon"></i>
                      <span>{{ act.label }}</span>
                    </button>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr v-if="paginatedRows.length === 0">
            <td :colspan="columns.length + (actions.length ? 1 : 0)" class="text-center">
              Tidak ada data
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <nav v-if="totalPages > 1">
      <ul class="pagination justify-content-center pagination-dark">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
        </li>
        <li
          class="page-item"
          v-for="page in totalPages"
          :key="page"
          :class="{ active: page === currentPage }"
        >
          <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
        </li>
      </ul>
    </nav>

  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  columns: { type: Array, required: true },
  rows: { type: Array, required: true },
  perPage: { type: Number, default: 10 },
  actions: { type: Array, default: () => [] } 
});

const currentPage = ref(1);

const totalPages = computed(() => Math.ceil(props.rows.length / props.perPage));

const paginatedRows = computed(() => {
  const start = (currentPage.value - 1) * props.perPage;
  return props.rows.slice(start, start + props.perPage);
});

function goToPage(page) {
  if (page < 1 || page > totalPages.value) return;
  currentPage.value = page;
}

function getValue(row, key) {
  return key.split(".").reduce((acc, part) => acc?.[part] ?? "-", row);
}
</script>

<style scoped>
.dropdown .btn {
  width: 32px;
  height: 32px;
  padding: 0;
  font-size: 18px;
  line-height: 1;
}

.dropdown-menu {
  min-width: 140px;
  font-size: 14px;
}
.dropdown-item i {
  font-size: 16px;
}
</style>
