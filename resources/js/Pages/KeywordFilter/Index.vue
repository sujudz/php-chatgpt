<template>
<div>
    <Head title="KeywordFilter" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/users">Setting</Link>
        <span class="text-indigo-400 font-medium">/</span>
        Sensitive Words Setting
      </h1>
      
    </div>

    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="container px-5 py-6 mx-auto flex sm:flex-nowrap flex-wrap">
          <div class="lg:w-1/1 md:w-1/1 bg-white flex flex-col md:ml-auto w-full mt-8 md:mt-0">
            <div class="relative mb-4">
              <label for="keywordFilterWord" class="leading-7 text-sm text-gray-600">Sensitive Words</label>
              <textarea :error="form.errors.keywordFilterWord" id="keywordFilterWord" name="keywordFilterWord" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-72 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" v-model="form.keywordFilterWord"></textarea>
            </div>
            <p class="text-gray-600">*Set a sensitive word for each line. If it is deployed, it is recommended to configure it.</p>
            <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Save</loading-button>
          </div>
        </div>

      </form>
    </div>
  </div>

</template>


<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import CheckBox from '@/Shared/CheckBox'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Link,
    TextInput,
    SelectInput,
    CheckBox,
    LoadingButton
  },
  props: {
    keywordFilterWord: String
  },
  layout: Layout,
  data() {
    return {
      form: this.$inertia.form({
        _method: 'post',
        keywordFilterWord: this.keywordFilterWord
      }),
    }
  },
  remember: 'form',
  methods: {
    store() {
      this.form.post('/keyword_filter')
    }
  },
}
</script>
