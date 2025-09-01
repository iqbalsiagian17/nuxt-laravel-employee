<template>
  <div class="form-check">
    <input
      class="form-check-input"
      type="radio"
      :id="id"
      :name="name"
      :value="value"
      :checked="modelValue === value"
      @change="$emit('update:modelValue', value)"
    />
    <label class="form-check-label" :for="id">
      {{ label }}
    </label>
  </div>
</template>

<script setup>
defineProps({
  id: String,
  name: String,
  value: [String, Number],
  label: String,
  modelValue: [String, Number] // prop untuk v-model
})

defineEmits(['update:modelValue']) // emit event untuk update
</script>
