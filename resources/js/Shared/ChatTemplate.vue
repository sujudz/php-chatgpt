<template>
  <div>
    <img :src="src" />
    <div>{{ content }}</div>
  </div>
</template>

<script>
export default {
  props: {
    src: String,
    content: String,
  },
}
</script>
