<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }} </label>
    <div v-for="item in list">
      <label v-if="label" class="form-label" :for="id">
      <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" class="form-checkbox checkbox" :class="{ error: error }" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
      {{ item }}
      </label>
      <div v-if="error" class="form-error">{{ error }}</div>
    </div>
  </div>
</template>

<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `checkbox-input-${uuid()}`
      },
    },
    type: {
      type: String,
      default: 'checkbox',
    },
    error: String,
    label: String,
    list: [],
    modelValue: String,
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
}
</script>
