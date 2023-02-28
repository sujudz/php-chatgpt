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
    <Head title="Prompt Edit" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/contacts">Prompt</Link>
      <span class="text-indigo-400 font-medium">/</span>Edit
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="pdate">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/1" label="Title" />

          <textarea-input v-model="form.desc" :error="form.errors.desc" class="pb-8 pr-6 w-full lg:w-1/1" label="Desc"></textarea-input>

          <input type="hidden" v-model="form.icon" name="icon" />

          <label class="form-label">Select Icon:</label>
          <div class="flex flex-wrap -ml-2" >
            <img :class="selectIconIndex == index ? 'select': '' " @click="selectIcon(index)" class="cursor-pointer icon my-2 mx-2" v-for="(icon, index) in icons" :src='icon' />
          </div>
          <textarea-input v-if="form.icon_type == 'svg' " v-model="form.icon" :error="form.errors.icon" class="pb-8 pr-6 w-full lg:w-1/1" label="SVG信息"></textarea-input>

        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button @click="destroy" class="text-red-600 hover:underline" tabindex="-1" type="button">Delete</button>

          <loading-button :loading="form.processing" class="ml-8 btn-indigo" type="submit">Save</loading-button>
        </div>
      </form>
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
        title: this.prompt.title,
        desc: this.prompt.desc,
        icon_type: this.prompt.icon_type,
        icon: this.prompt.icon
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
    destroy() {
      if (confirm('确认删除?')) {
        this.$inertia.delete(`/prompt/${this.prompt.id}`)
      }
    },
    pdate() {
      this.form.put(`/prompt/${this.prompt.id}/update`)
    },
  },
}
</script>
