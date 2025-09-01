<template>
  <div class="mb-3">
    <label v-if="label" class="form-label">{{ label }}</label>
    <select
      class="form-select"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option disabled value="">{{ placeholder }}</option>
      <option
        v-for="(item, index) in options"
        :key="index"
        :value="item.value"
      >
        {{ item.label }}
      </option>
    </select>
  </div>
</template>

<script setup>
defineProps({
  modelValue: {
    type: [String, Number],
    default: ""
  },
  options: {
    type: Array,
    default: () => []
  },
  placeholder: {
    type: String,
    default: "Pilih opsi"
  },
  label: {
    type: String,
    default: ""
  }
})

defineEmits(["update:modelValue"])
</script>
