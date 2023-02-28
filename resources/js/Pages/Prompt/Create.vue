<style>
  .icon {
    height: 36px;
    width: 36px;
  }

  .icon.select {
    border: 2px solid rgba(59, 130, 246);
    border-radius: 15px;
  }
</style>
<template>
  <div>
    <Head title="NewPrompt" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/contacts">Prompt</Link>
      <span class="text-indigo-400 font-medium">/</span>Create
    </h1>
    <div class="flex">
      <div class="w-3/4 bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="store">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/1" label="Title" />

            <textarea-input v-model="form.desc" :error="form.errors.desc" class="pb-8 pr-6 w-full lg:w-1/1" label="desc"></textarea-input>

            <input type="hidden" v-model="form.icon" name="icon" />

            <label class="form-label">Select Icon:</label>
            <div class="flex flex-wrap -ml-2" >
              <img :class="selectIconIndex == index ? 'select': '' " @click="selectIcon(index)" class="cursor-pointer icon my-2 mx-2" v-for="(icon, index) in icons" :src='icon' />
            </div>
            <textarea-input v-if="form.icon_type == 'svg' " v-model="form.icon" :error="form.errors.icon" class="pb-8 pr-6 w-full lg:w-1/1" label="SVG Info"></textarea-input>

          </div>

          <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
            <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create</loading-button>
          </div>
        </form>

      </div>
        
      <div class="w-1/4 ml-8 -mr-6 p-8 bg-white rounded-md ">
        <h3 class="font-bold">Q:How to add a customized question Prompt</h3>
        <div class="mt-4">A:AI AI system relies heavily on the context information given by the questioner to answer questions, because only in this way can it better analyze your intention in combination with the context.</div>
        <div class="mt-4">For example, I want you to act as a title generator for a small red book. I input keywords through commas, and you will reply to fancy titles, and add an expression before each title.</div>
        <div class="mt-4">After you add this as a template, next time you just need to select this template, and then enter the title information of the little red book you want AI to explain below, without having to enter a large amount of text every time.</div>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
  },
  layout: Layout,
  props: {
    prompt: Array,
  },
  remember: 'form',
  data() {
    return {
      icons:[],
      selectedIcon: "/img/icon/icon1.png",
      selectIconIndex: 0,
      form: this.$inertia.form({
        title: '',
        desc: '',
        icon_type: 'png',
        icon: ''
      }),
    }
  },
  created: function() {
    for(let i = 1; i <= 68; i++) {
      this.icons.push("/img/icon/icon" + i + ".png");
    }
  },
  methods: {
    selectIcon(index) {
      this.selectIconIndex = index;
      this.form.icon = "/img/icon/icon" + index + ".png"
    },
    store() {
      this.form.post('/prompt')
    },
  },
}
</script>
