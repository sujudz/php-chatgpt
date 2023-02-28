<template>
<div>
    <Head title="BaseSystem" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/users">Setting</Link>
        <span class="text-indigo-400 font-medium">/</span>
        Update
      </h1>
      
    </div>

    <div class="flex">
      <div class="w-3/4 bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="store">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            
            <text-input v-model="form.appname" :error="form.errors.appname" class="pb-8 pr-6 w-full lg:w-1/2" label="App Name" />

            <select-input v-model="form.keyword_filter_switch" :error="form.errors.keyword_filter_switch" class="pb-8 pr-6 w-full lg:w-1/2" label="Keyword Filter Switch">
              <option value="on">On</option>
              <option value="off">Off</option>
            </select-input>

            <select-input v-model="form.api_provider" :error="form.errors.api_provider" class="pb-8 pr-6 w-full lg:w-1/2" label="AI Provider">
              <option value="chatgpt">OpenAI ChatGPT</option>
              <option value="none">None</option>
            </select-input>


            <text-input v-if="form.api_provider == 'chatgpt'" v-model="form.api_token" :error="form.errors.api_token" class="pb-8 pr-6 w-full lg:w-1/2" label="API Token" />

            <text-input v-if="form.api_provider == 'chatgpt'" v-model="form.api_token_02" :error="form.errors.api_token_02" class="pb-8 pr-6 w-full lg:w-1/2" label="API Token 02" />

            <text-input v-if="form.api_provider == 'chatgpt'" v-model="form.api_token_03" :error="form.errors.api_token_03" class="pb-8 pr-6 w-full lg:w-1/2" label="API Token 03" />
          
          </div>
          <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">

            <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Save</loading-button>
          </div>
        </form>
      </div>
      <div class="w-1/4 ml-8 p-8 bg-white rounded-md shadow overflow-hidden">
        <p>* Multiple ApiTokens only guarantee that they will automatically switch according to the stuck state in the case of intelligent writing articles and other intelligent tools. "Smart conversation" mode is not available to ensure continuity.</p>
        <p class="mt-4">* It is recommended to turn on keyword filtering, you know.</p>
        <p class="mt-4">* Temporarily connect to the OpenAI interface, and wait for other programs to update.</p>
      </div>
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
    system: Object
  },
  layout: Layout,
  data() {
    return {
      form: this.$inertia.form({
        _method: 'post',
        api_token: this.system.value.api_token,
        api_token_02: this.system.value.api_token_02,
        api_token_03: this.system.value.api_token_03,
        appname: this.system.value.appname,
        api_provider: this.system.value.api_provider,

        keyword_filter_switch: this.system.value.keyword_filter_switch
      }),
    }
  },
  remember: 'form',
  methods: {
    store() {
      if (this.system.id > 0) {
        this.form.put('/setting')
        return;
      }
      this.form.post('/setting')
    }
  },
}
</script>
