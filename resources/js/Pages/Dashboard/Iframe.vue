<template>


</template>


<script>
import { Head, Link } from '@inertiajs/inertia-vue3'

export default {
  components: {
    Head,
    Link
  },
  props: {
    system: Object
  },
  data() {
    return {
      form: this.$inertia.form({
        _method: 'post'
      }),
    }
  },
  methods: {
    
  },
}
</script>
